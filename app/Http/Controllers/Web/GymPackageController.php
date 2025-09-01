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
class GymPackageController extends Controller
{
    public function list()
    {
        return view('gym_packages.list');
    }

    // public function fetchMemberList(Request $request)
    // {
    //     // ONE variable that fetches everything you need
    //     $fetch_data = DB::table('tbl_gym_members')
    //         ->select('*');

    //     // Send to DataTables (server-side)
    //     return DataTables::of($fetch_data)
    //         ->addColumn('action', function ($row) {
    //             return '<a href="/edit_member'.$row->id.'" class="btn btn-sm btn-primary">Edit</a>
    //                     <a href="/members/delete/'.$row->id.'" class="btn btn-sm btn-danger">Delete</a>';
    //         })
    //         ->rawColumns(['action'])
    //         ->make(true);
    // }

    public function fetchMemberList(Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_gym_members')
            ->select('*');
            // ->where('is_deleted', '!=', 9);

        // Apply filters
        if ($request->filled('active')) {
            $query->where('is_active', $request->active);
        }

        if ($request->filled('trainer')) {
            // Convert 1 => 'yes', 0 => 'no'
            $trainerValue = $request->trainer == 1 ? 'yes' : 'no';
            $query->where('trainer_included', $trainerValue);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $allowedSorts = [
            'id',
            'first_name',
            'email',
            'mobile',
            'membership_type',
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
                <button type="button" class="btn btn-sm" onclick="delete_members('.$row->id.')">
                    <i class="bi bi-trash"></i>
                </button>';
            return $row;
        });

        return response()->json($memberships);
    }

   
    
    public function add()
    {
        $memberships = DB::table('tbl_gym_membership')
        ->where('is_active', 1)
        ->pluck('membership_name', 'id'); 
        $trainer=DB::table('tbl_trainer')
        ->where('is_active', 1)
        ->pluck('trainer_name', 'id');
        return view('gym_packages.add_form', compact('memberships','trainer'));
    }

    public function submit(Request $request)
    {
        // dd($request->all());
        // Validation rules
        $arr_rules = 
        [
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'first_name' => 'required|max:100',
            'middle_name' => 'nullable|max:100',
            'last_name' => 'required|max:100',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'residence_address' => 'required|string',
            'residence_area' => 'nullable|string',
            'zipcode' => 'required|digits:6',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
    
            'membership_type' => 'required|int',
            'joining_date' => 'required|date',
            'expiry_date' => 'required|date',
            'amount_paid' => 'required|numeric',
            'payment_method' => 'required|string',
            'trainer_assigned' => 'required|string',
    
            'fitness_goals' => 'required|string',
            'preferred_workout_time' => 'required|string',
            'current_weight' => 'nullable|numeric',
            'additional_notes' => 'nullable|string',
        ];
    
        // Validate the inputs
        $validator = Validator::make($request->all(), $arr_rules);
        // dd($validator);
    
        if ($validator->fails()) 
        {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = $validator->messages();
            return response()->json($arr_resp, 400);
        }
    
        DB::beginTransaction();
    
        try 
        {
            // dd(1);
            // Insert all request data exactly as received

            $user_details_arr = $request->all();
            // dd( $user_details_arr);

            
            if ($request->hasFile('profile_image')) 
            {
                $image = $request->file('profile_image');
                $imageName = time().'_'.$image->getClientOriginalName();
                $image->move(public_path('uploads/profile_images'), $imageName);
                $user_details_arr['profile_image'] = 'uploads/profile_images/' . $imageName;
            } 
            else 
            {
                $user_details_arr['profile_image'] = null; // or default path
            }
    
            $inserted_id = DB::table('tbl_gym_members')->insertGetId($user_details_arr);
            // Create user for login
            $full_name = $request->first_name . ' ' . $request->last_name;

            DB::table('users')->insert([
                'name' => $full_name,
                'email' => $request->email,
                'password' => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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

    public function edit($id)
    {
        try 
        {
            $member = DB::table('tbl_gym_members')->where('id', $id)->first();
    
            if (!$member) 
            {
                dd("Page not found");
                return redirect()->back()->with('error', 'Member not found!');
            }
    
            return view('tabs.index', compact('member'));
        } 
        catch (\Exception $e)
        {
            // dd($e->getMessage());
            Log::error('Edit member failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching the member.');
        }
    }

    public function update(Request $request,$id)
    {
        // dd(1);
        // dd($request->all());
        // Validation rules
        $arr_rules = 
        [
            'membership_type' => 'required|string',
            'joining_date' => 'required|date',
            'expiry_date' => 'required|date',
            'amount_paid' => 'required|numeric',
            'payment_method' => 'required|string',
            'trainer_assigned' => 'required|string',
        ];
    
        // Validate the inputs
        $validator = Validator::make($request->all(), $arr_rules);
        // dd($validator);
    
        if ($validator->fails()) 
        {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = $validator->messages();
            return response()->json($arr_resp, 400);
        }
    
        DB::beginTransaction();
    
        try 
        {
            // dd(111);
            // Insert all request data exactly as received

            $user_details_arr = $request->all();
            // dd( $user_details_arr);

            
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
    
            // Update existing record by ID
            $updated = DB::table('tbl_gym_members')
            ->where('id', $id)
            ->update($user_details_arr);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => $updated ? 'Member updated successfully' : 'No record updated',
                'id'      => $id
            ], 200);
           
    
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:Monthly,Quarterly,Yearly,Session',
            'price' => 'required|numeric|min:0'
        ]);

        DB::table('gym_packages')->insert($validated);

        return response()->json([
            'success' => true,
            'message' => 'Gym Package created successfully.'
        ]);
    }
    public function delete_members($id)
    {
        // dd(1);
        $membership = DB::table('tbl_gym_members')->where('id', $id)->first();
        // dd($membership);
        if (!$membership) 
        {
            return response()->json(['status' => false, 'message' => 'Membership not found'], 404);
        }

        DB::table('tbl_gym_members')
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

}
