<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Header;

class HeaderController extends Controller
{
    /* =======================
     * LIST PAGE
     * ======================= */
    public function list()
    {
        return view('header.list_header');
    }

    /* =======================
     * FETCH HEADERS
     * ======================= */
    public function fetch_headers(Request $request)
    {
        $query = DB::table('headers')
            ->where('is_deleted', '!=', 9);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

       
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Sorting
        $allowedSorts = ['id', 'title', 'sequence_no'];
        $sort = $request->get('sort', 'sequence_no');
        $order = $request->get('order', 'asc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'sequence_no';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $query->orderBy($sort, $order);

        $headers = $query->paginate(10);

        $headers->getCollection()->transform(function ($row) {
            $row->action = '
                <a href="' . route('edit_header', $row->id) . '" class="btn btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button class="btn btn-sm" onclick="deleteHeader(' . $row->id . ')">
                    <i class="bi bi-trash"></i>
                </button>';
            return $row;
        });

        return response()->json($headers);
    }

    /* =======================
     * ADD PAGE
     * ======================= */
    public function add()
    {
        return view('header.add_header');
    }

    /* =======================
     * STORE HEADER
     * ======================= */
    public function store(Request $request)
    {
        $rules = [
            'title'       => 'required|string|max:255',
            'sequence_no' => 'required|numeric',
            'status'      => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        try {
            Header::create([
                'title'       => $request->title,
                'sequence_no' => $request->sequence_no,
                'status'      => $request->status,
                'is_deleted'  => 0,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Header added successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Header Store Error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /* =======================
     * EDIT PAGE
     * ======================= */
    public function edit($id)
    {
        $header = Header::find($id);

        if (!$header) {
            abort(404, 'Header not found');
        }

        return view('header.edit_header', compact('header'));
    }

    /* =======================
     * UPDATE HEADER
     * ======================= */
    public function update(Request $request, $id)
    {
        $rules = [
            'title'       => 'required|string|max:255',
            'sequence_no' => 'required|numeric',
            'status'      => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        try {
            Header::where('id', $id)->update([
                'title'       => $request->title,
                'sequence_no' => $request->sequence_no,
                'status'      => $request->status,
                'updated_at'  => now(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Header updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /* =======================
     * DELETE HEADER
     * ======================= */
    public function delete($id)
    {
        $header = Header::find($id);

        if (!$header) {
            return response()->json([
                'status'  => false,
                'message' => 'Header not found'
            ], 404);
        }

        $header->is_deleted = 9;
        $header->save();

        return response()->json([
            'status'  => true,
            'message' => 'Header deleted successfully'
        ]);
    }

    /* =======================
     * ACTIVATE HEADER
     * ======================= */
    public function activate($id)
    {
        $header = Header::where('id', $id)
            ->where('is_deleted', 9)
            ->first();

        if (!$header) {
            return response()->json([
                'status'  => false,
                'message' => 'Header not found'
            ], 404);
        }

        $header->is_deleted = 0;
        $header->save();

        return response()->json([
            'status'  => true,
            'message' => 'Header activated successfully'
        ]);
    }
    /* =======================
    * LIST DELETED HEADERS
    * ======================= */
    public function list_deleted_headers()
    {
        // dd(1);
        return view('header.list_deleted_header');
    }
    /* =======================
    * FETCH DELETED HEADERS
    * ======================= */
    public function fetch_deleted_headers(Request $request)
    {
        $query = DB::table('headers')
            ->where('is_deleted', '=', 9);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Sorting
        $allowedSorts = [
            'id',
            'title',
            'sequence_no',
            'status',
            'created_at'
        ];

        $sort = $request->get('sort', 'id');
        $direction = $request->get('order', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        // Pagination
        $headers = $query->paginate(10);

        // Action button (ACTIVATE)
        $headers->getCollection()->transform(function ($row) {
            $row->action = '
                <button type="button" class="btn btn-sm"
                    onclick="activateHeaderById('.$row->id.')">
                    <i class="bi bi-check-circle"></i>
                </button>';
            return $row;
        });

        return response()->json($headers);
    }

    
}
