<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\SubHeader;
use App\Models\Header;

class SubHeaderController extends Controller
{
    /* =======================
     * LIST PAGE
     * ======================= */
    public function list()
    {
        $headers = Header::where('is_deleted', 0)->get();
        return view('subheader.list_subheader', compact('headers'));
    }

    public function list_deleted_subheaders()
    {
        $headers = Header::where('is_deleted', 9)->get();
        return view('subheader.list_deleted_subheader', compact('headers'));
    }
    /* =======================
     * FETCH SUBHEADERS
     * ======================= */
    public function fetch_subheaders(Request $request)
    {
        $query = DB::table('subheaders as sh')
            ->join('headers as h', 'h.id', '=', 'sh.header_id')
            ->where('sh.is_deleted', '!=', 9)
            ->select(
                'sh.*',
                'h.title as header_name'
            );

        if ($request->filled('status')) {
            $query->where('sh.status', $request->status);
        }

        if ($request->filled('header_id')) {
            $query->where('sh.header_id', $request->header_id);
        }
        if ($request->filled('name')) {
            $query->where('sh.name', 'like', '%' . $request->name . '%');
        }

        $subheaders = $query->orderBy('sh.id', 'desc')->paginate(10);

        $subheaders->getCollection()->transform(function ($row) {
            $row->action = '
                <a href="' . route('edit_subheader', $row->id) . '" class="btn btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button class="btn btn-sm" onclick="deleteSubHeader('.$row->id.')">
                    <i class="bi bi-trash"></i>
                </button>';
            return $row;
        });

        return response()->json($subheaders);
    }

    public function fetch_deleted_subheaders(Request $request)
    {
        $query = DB::table('subheaders as sh')
            ->join('headers as h', 'h.id', '=', 'sh.header_id')
            ->where('sh.is_deleted', '=', 9)
            ->select(
                'sh.*',
                'h.title as header_name'
            );
    
        // Filters
        if ($request->filled('status')) {
            $query->where('sh.status', $request->status);
        }
    
        if ($request->filled('name')) {
            $query->where('sh.name', 'like', '%' . $request->name . '%');
        }
    
        // Sorting
        $allowedSorts = [
            'id',
            'name',
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
    
        $query->orderBy('sh.' . $sort, $direction);
    
        // Pagination
        $subheaders = $query->paginate(10);
    
        // Action button (ACTIVATE)
        $subheaders->getCollection()->transform(function ($row) {
            $row->action = '
                <button type="button" class="btn btn-sm"
                    onclick="activateSubHeaderById('.$row->id.')">
                    <i class="bi bi-check-circle"></i>
                </button>';
            return $row;
        });
    
        return response()->json($subheaders);
    }
    
    /* =======================
     * ADD PAGE
     * ======================= */
    public function add()
    {
        $headers = Header::where('is_deleted', 0)->get();
        return view('subheader.add_subheader', compact('headers'));
    }

    /* =======================
     * STORE SUBHEADER
     * ======================= */
    public function store(Request $request)
    {
        // dd(1);
        $rules = [
            'header_id' => 'required|exists:headers,id',
            'name'      => 'required|string|max:255',
            'status'    => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        try {
            SubHeader::create([
                'header_id' => $request->header_id,
                'name'      => $request->name,
                'status'    => $request->status,
                'is_deleted'=> 0,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'SubHeader added successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('SubHeader Store Error: '.$e->getMessage());

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
        $subheader = SubHeader::findOrFail($id);
        $headers = Header::where('is_deleted', 0)->get();

        return view('subheader.edit_subheader', compact('subheader', 'headers'));
    }

    /* =======================
     * UPDATE SUBHEADER
     * ======================= */
    public function update(Request $request, $id)
    {
        $rules = [
            'header_id' => 'required|exists:headers,id',
            'name'      => 'required|string|max:255',
            'status'    => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        SubHeader::where('id', $id)->update([
            'header_id' => $request->header_id,
            'name'      => $request->name,
            'status'    => $request->status,
            'updated_at'=> now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'SubHeader updated successfully'
        ]);
    }

    /* =======================
     * DELETE SUBHEADER
     * ======================= */
    public function delete($id)
    {
        $subheader = SubHeader::find($id);

        if (!$subheader) {
            return response()->json([
                'status' => false,
                'message' => 'SubHeader not found'
            ], 404);
        }

        $subheader->is_deleted = 9;
        $subheader->save();

        return response()->json([
            'status' => true,
            'message' => 'SubHeader deleted successfully'
        ]);
    }

    /* =======================
     * ACTIVATE SUBHEADER
     * ======================= */
    public function activate($id)
    {
        $subheader = SubHeader::where('id', $id)
            ->where('is_deleted', 9)
            ->first();

        if (!$subheader) {
            return response()->json([
                'status' => false,
                'message' => 'SubHeader not found'
            ], 404);
        }

        $subheader->is_deleted = 0;
        $subheader->save();

        return response()->json([
            'status' => true,
            'message' => 'SubHeader activated successfully'
        ]);
    }
}
