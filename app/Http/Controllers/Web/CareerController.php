<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Career;

class CareerController extends Controller
{
    /* =======================
     * LIST PAGE
     * ======================= */
    public function list()
    {
        return view('career.list_career');
    }

    /* =======================
     * FETCH CAREERS
     * ======================= */
    public function fetch_careers(Request $request)
    {
        $query = DB::table('tbl_careers')
            ->where('is_deleted', '!=', 9);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('designation')) {
            $query->where('designation', 'like', '%' . $request->designation . '%');
        }

        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        // Sorting
        $allowedSorts = [
            'id',
            'designation',
            'years_of_experience',
            'location',
            'work_type',
            'created_at'
        ];

        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query->orderBy($sort, $order);

        // Pagination
        $careers = $query->paginate(10);

        // Action buttons
        $careers->getCollection()->transform(function ($row) {
            $row->action = '
                <a href="' . route('edit_career', $row->id) . '" class="btn btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button class="btn btn-sm" onclick="deleteCareer(' . $row->id . ')">
                    <i class="bi bi-trash"></i>
                </button>';
            return $row;
        });

        return response()->json($careers);
    }

    /* =======================
     * ADD PAGE
     * ======================= */
    public function add()
    {
        return view('career.add_career');
    }

    /* =======================
     * STORE CAREER
     * ======================= */
    public function store(Request $request)
    {
        $rules = [
            'designation'             => 'required|string|max:255',
            'years_of_experience'     => 'required|numeric|min:0',
            'job_description'         => 'required|string',
            'location'                => 'nullable|string|max:255',
            'work_type'               => 'required|in:wfo,wfh,remote',
            'vacancies'               => 'required|integer|min:1',
            'application_start_date'  => 'required|date',
            'application_end_date'    => 'required|date|after_or_equal:application_start_date',
            'status'                  => 'required|boolean',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }
    
        try {
            Career::create([
                'designation'             => $request->designation,
                'years_of_experience'     => $request->years_of_experience,
                'job_description'         => $request->job_description,
                'location'                => $request->location,
                'work_type'               => $request->work_type,
                'vacancies'               => $request->vacancies,
                'application_start_date'  => $request->application_start_date,
                'application_end_date'    => $request->application_end_date,
                'status'                  => $request->status,
                'is_deleted'              => 0,
            ]);
    
            return response()->json([
                'status'  => 'success',
                'message' => 'Career added successfully'
            ]);
    
        } catch (\Exception $e) {
            Log::error('Career Store Error: ' . $e->getMessage());
    
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
        $career = Career::find($id);

        if (!$career) {
            abort(404, 'Career not found');
        }

        return view('career.edit_career', compact('career'));
    }

    /* =======================
     * UPDATE CAREER
     * ======================= */
    public function update(Request $request, $id)
    {
        $rules = [
            'designation' => 'required|string|max:255',
            'years_of_experience' => 'required|numeric|min:0',
            'vacancies' => 'required|integer|min:1',
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after_or_equal:application_start_date',
            'job_description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'work_type' => 'required|in:wfo,wfh,remote',
            'status' => 'required|boolean',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->messages()], 422);
        }
    
        Career::where('id', $id)->update([
            'designation' => $request->designation,
            'years_of_experience' => $request->years_of_experience,
            'vacancies' => $request->vacancies,
            'application_start_date' => $request->application_start_date,
            'application_end_date' => $request->application_end_date,
            'job_description' => $request->job_description,
            'location' => $request->location,
            'work_type' => $request->work_type,
            'status' => $request->status,
            'updated_at' => now(),
        ]);
    
        return response()->json(['status' => 'success', 'message' => 'Career updated successfully']);
    }
    
    /* =======================
     * DELETE CAREER
     * ======================= */
    public function delete($id)
    {
        $career = Career::find($id);

        if (!$career) {
            return response()->json([
                'status'  => false,
                'message' => 'Career not found'
            ], 404);
        }

        $career->is_deleted = 9;
        $career->save();

        return response()->json([
            'status'  => true,
            'message' => 'Career deleted successfully'
        ]);
    }

    /* =======================
     * ACTIVATE CAREER
     * ======================= */
    public function activate($id)
    {
        $career = Career::where('id', $id)
            ->where('is_deleted', 9)
            ->first();

        if (!$career) {
            return response()->json([
                'status'  => false,
                'message' => 'Career not found'
            ], 404);
        }

        $career->is_deleted = 0;
        $career->save();

        return response()->json([
            'status'  => true,
            'message' => 'Career activated successfully'
        ]);
    }

    /* =======================
     * LIST DELETED CAREERS
     * ======================= */
    public function list_deleted_careers()
    {
        return view('career.list_deleted_career');
    }

    /* =======================
     * FETCH DELETED CAREERS
     * ======================= */
    public function fetch_deleted_careers(Request $request)
    {
        $query = DB::table('tbl_careers')
            ->where('is_deleted', '=', 9);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('designation')) {
            $query->where('designation', 'like', '%' . $request->designation . '%');
        }

        // Sorting
        $allowedSorts = [
            'id',
            'designation',
            'years_of_experience',
            'work_type',
            'created_at'
        ];

        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query->orderBy($sort, $order);

        // Pagination
        $careers = $query->paginate(10);

        // Action button (ACTIVATE)
        $careers->getCollection()->transform(function ($row) {
            $row->action = '
                <button type="button" class="btn btn-sm"
                    onclick="activateCareerById('.$row->id.')">
                    <i class="bi bi-check-circle"></i>
                </button>';
            return $row;
        });

        return response()->json($careers);
    }

    public function index()
    {
        $careers = DB::table('tbl_careers')
            ->where('is_deleted', 0)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
            // dd($careers);

        return view('front.careers', compact('careers'));
    }
}
