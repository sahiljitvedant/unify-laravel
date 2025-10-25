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

class GymMembershipController extends Controller
{
   
    public function list()
    {
        return view('gym_membership.list_membership');
       
    }
    
 
    public function fetchMembership(Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_gym_membership')
            ->select('*')
            ->where('is_deleted', '!=','1');

        // Apply filters
        if ($request->filled('active')) {
            $query->where('is_active', $request->active);
        }

        if ($request->filled('trainer')) {
            // Convert 1 => '1', 0 => '0' (string) to match ENUM in DB
            $trainerValue = $request->trainer == 1 ? '1' : '0';
            $query->where('trainer_included', $trainerValue);
        }
        

        if ($request->filled('durartion')) {  
            $query->where('duration_in_days', $request->durartion);
        }
        if ($request->filled('membership_name')) {  
            $query->where('membership_name', 'LIKE', $request->membership_name . '%');
        }
        
        if ($request->filled('price')) {
            $query->where('price', $request->price);
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
                <a href="'.route('edit_membership', $encryptedId).'" class="btn btn-sm" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-sm" onclick="deleteMembershipById('.$row->id.')">
                    <i class="bi bi-trash"></i>
                </button>';
            return $row;
        });

        return response()->json($memberships);
    }


    public function list_deleted_membership()
    {
        return view('gym_membership.list_deleted_membership');

    }


    public function fetch_deleted_membership(Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_gym_membership')
            ->select('*')
            ->where('is_deleted', '=','1') ;

        // Apply filters
         // Apply filters
         if ($request->filled('active')) {
            $query->where('is_active', $request->active);
        }

        if ($request->filled('trainer')) {
            // Convert 1 => '1', 0 => '0' (string) to match ENUM in DB
            $trainerValue = $request->trainer == 1 ? '1' : '0';
            $query->where('trainer_included', $trainerValue);
        }

        if ($request->filled('durartion')) {  
            $query->where('duration_in_days', $request->durartion);
        }
        if ($request->filled('membership_name')) {  
            $query->where('membership_name', 'LIKE', $request->membership_name . '%');
        }
        if ($request->filled('price')) {
            $query->where('price', $request->price);
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
        return view('gym_membership.add_form');
    }

    public function submit(Request $request)
    {
        $input = $request->all();
    
        $arr_rules = [
            'membership_name' => 'required|string|max:150|unique:tbl_gym_membership,membership_name',
            'description' => 'nullable|string|max:500',
            'duration_in_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'trainer_included' => 'required|in:0,1', // matches ENUM
            'facilities_included' => 'nullable|array',
            'facilities_included.*' => 'integer', 
            'is_active' => 'required|in:0,1', // matches ENUM
        ];
    
        $validator = Validator::make($input, $arr_rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }
    
        DB::beginTransaction();
    
        try {
            // Convert facilities array → JSON
            if (isset($input['facilities_included'])) {
                $input['facilities_included'] = json_encode($input['facilities_included']);
            }
    
            // Set is_deleted = 0 for new memberships
            $input['is_deleted'] = '0';
    
            $inserted_id = DB::table('tbl_gym_membership')->insertGetId($input);
    
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Member added successfully',
                'member_id' => $inserted_id
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

    public function deleteMembership($id)
    {
        // dd(1);
        $membership = DB::table('tbl_gym_membership')->where('id', $id)->first();
        // dd($membership);
        if (!$membership) 
        {
            return response()->json(['status' => false, 'message' => 'Membership not found'], 404);
        }

        DB::table('tbl_gym_membership')
        ->where('id', $id)
        ->update([
            'is_deleted' => '1',  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Membership deleted successfully'
        ]);
    }

    public function edit($id)
    {
        
        // dd($id);
        $decryptedId = Crypt::decryptString($id);
        // dd($decryptedId);
        $member = DB::table('tbl_gym_membership')->where('id', $decryptedId)->first();

        if (!$member) {
            abort(404, 'Member not found');
        }

        // Pass existing member data into the form
        return view('gym_membership.edit_form', compact('member'));
    }

    // Handle update
    public function update(Request $request, $id)
    {
        try 
        {
            $request->validate([
                'membership_name'      => 'required|string|unique:tbl_gym_membership,membership_name,' . $id,
                'description'          => 'required|string',
                'duration_in_days'     => 'required|numeric',
                'price'                => 'required|numeric',
                'trainer_included'     => 'required|in:0,1',
                'facilities_included'  => 'required|array',
                'is_active'            => 'required|in:0,1',
            ]);
    
            // Ensure facilities is always array
            $facilities = $request->facilities_included;
            if (!is_array($facilities)) {
                $facilities = [$facilities];
            }
    
            // Update using DB
            DB::table('tbl_gym_membership')
                ->where('id', $id)
                ->update([
                    'membership_name'     => $request->membership_name,
                    'is_active'           => $request->is_active,
                    'description'         => $request->description,
                    'duration_in_days'    => $request->duration_in_days,
                    'price'               => $request->price,
                    'trainer_included'    => $request->trainer_included,
                    'facilities_included' => json_encode($facilities),
                    'updated_at'          => now(),
                ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Membership updated successfully!'
            ]);
    
        } 
        catch (\Illuminate\Validation\ValidationException $e) 
        {
            // Return validation errors as JSON
            return response()->json([
                'success' => false, 
                'errors'  => $e->errors()
            ], 422);
        }
        catch (\Exception $e) 
        {
            // Return general errors
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function activate_membership($id)
    {
        // dd(1);
        $membership = DB::table('tbl_gym_membership')->where('id', $id)->first();
        // dd($membership);
        if (!$membership) 
        {
            return response()->json(['status' => false, 'message' => 'Membership not found'], 404);
        }

        DB::table('tbl_gym_membership')
        ->where('id', $id)
        ->update([
            'is_deleted' => 1,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Membership activated successfully'
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
