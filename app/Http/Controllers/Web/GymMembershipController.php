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
        // dd(1);
        // ONE variable that fetches everything you need
        $fetch_data = DB::table('tbl_gym_membership')
            ->select('*')
            ->where('is_deleted', '!=', 9) 
            ->orderBy('id', 'desc')
            ->get();

        // Send to DataTables (server-side)
        return DataTables::of($fetch_data)
            ->addColumn('action', function ($row) 
            {
                $encryptedId = Crypt::encryptString($row->id);
                return ' 
                <a href="'.route('edit_membership', $encryptedId).'" class="btn btn-sm" data-bs-toggle="tooltip" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-sm" onclick="deleteMembershipById('.$row->id.')">
                    <i class="bi bi-trash"></i>
                </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function list_deleted_membership()
    {
        return view('gym_membership.list_deleted_membership');

    }

    public function fetch_deleted_membership(Request $request)
    {
        // dd(1);
        // ONE variable that fetches everything you need
        $fetch_data = DB::table('tbl_gym_membership')
            ->select('*')
            ->where('is_deleted', '=', 9) 
            ->orderBy('id', 'desc')
            ->get();

        // Send to DataTables (server-side)
        return DataTables::of($fetch_data)
            ->addColumn('action', function ($row) 
            {
                $encryptedId = Crypt::encryptString($row->id);
                return ' 
                
                <button type="button" class="btn btn-sm" onclick="activateMembershipID('.$row->id.')">
                <i class="bi bi-check-circle"></i>

                </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function add()
    {
        // dd(1);
        return view('gym_membership.add_form');
    }

    public function submit(Request $request)
    {
        // dd($request->all());
        // Validation rules
        $arr_rules = [
            'membership_name' => 'required|string|max:150|unique:tbl_gym_membership,membership_name',
            'description' => 'nullable|string|max:500',
            'duration_in_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'trainer_included' => 'required|in:yes,no',
            'facilities_included' => 'nullable|array',
            'facilities_included.*' => 'integer', 
            'is_active' => 'required|boolean',
        ];
        // Validate the inputs
        $validator = Validator::make($request->all(), $arr_rules);
        // dd($validator);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }
    
    
        DB::beginTransaction();
    
        try 
        {
            // dd(1);
            // Insert all request data exactly as received

            $user_details_arr = $request->all();
            // dd( $user_details_arr);

              // Convert array → JSON for DB
        if ($request->has('facilities_included')) {
            $user_details_arr['facilities_included'] = json_encode($request->facilities_included);
        }

            
            // if ($request->hasFile('profile_image')) 
            // {
            //     $image = $request->file('profile_image');
            //     $imageName = time().'_'.$image->getClientOriginalName();
            //     $image->move(public_path('uploads/profile_images'), $imageName);
            //     $user_details_arr['profile_image'] = 'uploads/profile_images/' . $imageName;
            // } 
            // else 
            // {
            //     $user_details_arr['profile_image'] = null; // or default path
            // }
    
            $inserted_id = DB::table('tbl_gym_membership')->insertGetId($user_details_arr);
           
            DB::commit();
    
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = 'Member added successfully';
            $arr_resp['member_id'] = $inserted_id;
            return response()->json($arr_resp);
    
        } 
        catch (\Exception $e) 
        {
            DB::rollback();
            Log::error($e->getMessage());
    
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = $e->getMessage();
            return response()->json($arr_resp, 500);
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
            'is_deleted' => 9,  
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
        // dd('This is edit page');

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
                'membership_name' => 'required|string|min:3|max:5|unique:tbl_gym_membership,membership_name,' . $id,
                'description'     => 'required|string',
                'duration_in_days'=> 'required|numeric',
                'price'           => 'required|numeric',
                'trainer_included'=> 'required',
                'facilities_included' => 'required|array',
                'is_active'       => 'required',
            ]);
    
            // Ensure facilities is always array, even if only one checkbox selected
            $facilities = $request->facilities_included ?? [];
            if (!is_array($facilities)) {
                $facilities = [$facilities];
            }
    
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
    
            return response()->json(['success' => true, 'message' => 'Membership updated successfully!']);
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
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
        catch (\Exception $e) 
        {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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

      
}
