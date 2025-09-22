<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables; 
use Illuminate\Support\Facades\Crypt;

class FAQController extends Controller
{
   
    public function list()
    {
        return view('faqs.list_faqs');

    }
    
   

    public function fetch_faqs(Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_faqs')
            ->select('*')
            ->where('is_deleted', '!=', 9);

        // Apply filters
        if ($request->filled('active')) {
            $query->where('status', $request->active);
        }

      
        
        if ($request->filled('question')) {
            $query->where('question', $request->question);
        }

        // Sorting
        $allowedSorts = [
            'id',
            'membership_name',
            'duration_in_days',
            'price',
            'trainer_included',
            'is_active',
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
        $memberships = $query->paginate(10);

        // Add action + encrypted_id
        $memberships->getCollection()->transform(function ($row) {
            $encryptedId = Crypt::encryptString($row->id);
            $row->encrypted_id = $encryptedId;
            $row->action = '
                <a href="'.route('edit_faq', $encryptedId).'" class="btn btn-sm" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-sm" onclick="deleteMembershipById('.$row->id.')">
                    <i class="bi bi-trash"></i>
                </button>';
            return $row;
        });

        return response()->json($memberships);
    }


    public function list_deleted_faqs()
    {
        return view('faqs.list_deleted_faqs');
    }

    
    public function fetch_deleted_faqs(Request $request)
    {
        $query = DB::table('tbl_faqs')
            ->select('*')
            ->where('is_deleted', '!=', 0);

        // Apply filters
        if ($request->filled('active')) {
            $query->where('status', $request->active);
        }
        
        if ($request->filled('question')) {
            $query->where('question', $request->question);
        }

        // Sorting
        $allowedSorts = [
            'id',
            'membership_name',
            'duration_in_days',
            'price',
            'trainer_included',
            'is_active',
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
        $memberships = $query->paginate(10);

        // Add action + encrypted_id
        $memberships->getCollection()->transform(function ($row) {
            $encryptedId = Crypt::encryptString($row->id);
            $row->encrypted_id = $encryptedId;
            $row->action = '
                <button type="button" class="btn btn-sm" onclick="activateMembershipID('.$row->id.')">
                    <i class="bi bi-check-circle"></i>
                </button>
                ';
            return $row;
        });

        return response()->json($memberships);
    }

    public function add()
    {
        // dd(1);
      
        return view('faqs.add_form');
    }

    public function update_faqs(Request $request, $id)
    {
        // Validation rules
        $arr_rules = [
            'question' => 'required|string|max:255|unique:tbl_faqs,question,' . $id,
            'answer' => 'required|string',
            'youtube_link' => 'nullable|url|max:255',
            'faq_image' => 'nullable|string',
            'is_active' => 'required|boolean',
            'is_deleted' => 'nullable|in:0,9',
        ];
    
        $validator = Validator::make($request->all(), $arr_rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }
    
        DB::beginTransaction();
    
        try {
            $faqData = $request->only([
                'question',
                'answer',
                'youtube_link',
                'faq_image',
                'is_deleted'
            ]);
    
            // Map is_active to status
            $faqData['status'] = $request->is_active;
    
            // Defaults
            $faqData['is_deleted'] = $faqData['is_deleted'] ?? 0;
    
            // Update DB
            DB::table('tbl_faqs')
                ->where('id', $id)
                ->update($faqData);
    
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'FAQ updated successfully',
            ]);
    
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function delete_faqs($id)
    {
        // dd(1);
        $membership = DB::table('tbl_faqs')->where('id', $id)->first();
        // dd($membership);
        if (!$membership) 
        {
            return response()->json(['status' => false, 'message' => 'FAQ not found'], 404);
        }

        DB::table('tbl_faqs')
        ->where('id', $id)
        ->update([
            'is_deleted' => 9,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'FAQ deleted successfully'
        ]);
    }

    public function edit($id)
    {
        
        // dd($id);
        // dd('This is edit page');
        $decryptedId = Crypt::decryptString($id);
        // dd($decryptedId);
        $faq = DB::table('tbl_faqs')->where('id', $decryptedId)->first();

        if (!$faq) {
            abort(404, 'Member not found');
        }

        // Pass existing member data into the form
        return view('faqs.edit_form', compact('faq'));

    }

    // Handle update
    public function activate_faqs($id)
    {
        // dd(1);
        $membership = DB::table('tbl_faqs')->where('id', $id)->first();
        // dd($membership);
        if (!$membership) 
        {
            return response()->json(['status' => false, 'message' => 'FAQ not found'], 404);
        }

        DB::table('tbl_faqs')
        ->where('id', $id)
        ->update([
            'is_deleted' => 0,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'FAQ activated successfully'
        ]);
    }

    
    public function get_membership_name(Request $request)
    {
        $query = trim($request->get('q'));

        if (empty($query)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Search cannot be empty.'
            ], 422);
        }

        $membership = DB::table('tbl_gym_membership')
            ->where('membership_name', 'LIKE', "%{$query}%")
            ->select('id', 'membership_name')
            ->first();

        if (!$membership) {
            return response()->json([
                'status' => 'error',
                'message' => 'No Membership found by this Name'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'id' => Crypt::encryptString($membership->id), // ENCRYPT ID
            'name' => $membership->membership_name
        ]);
    }

}
