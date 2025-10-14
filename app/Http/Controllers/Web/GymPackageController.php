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



    public function fetchMemberList(Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_gym_members as gm')
        ->join('tbl_gym_membership as ms', 'gm.membership_type', '=', 'ms.id')
        ->select(
            'gm.*',
            'ms.membership_name',
            'ms.duration_in_days',
            'ms.price',
            'ms.description'
        )
        ->where('gm.is_deleted', '!=', 9);

        // Apply filters
        if ($request->filled('first_name')) {
            $query->where('gm.first_name', 'like', "%{$request->first_name}%");
        }
        
        if ($request->filled('mobile')) {
            $query->where('gm.mobile', 'like', "%{$request->mobile}%");
        }
        
        if ($request->filled('email')) {
            $query->where('gm.email', 'like', "%{$request->email}%");
        }
        
        // Sorting
        $allowedSorts = [
            'gm.id',
            'gm.first_name',
            'gm.email',
            'gm.mobile',
            'gm.membership_type',
            'ms.membership_name',
            'ms.price',
            'gm.amount_paid'
        ];
        
        $sort = $request->get('sort', 'id');
        $direction = $request->get('order', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'gm.id';
        }
        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'desc';
        }
        if ($sort === 'fees_pending') {
            $query->orderByRaw('(ms.price - gm.amount_paid) ' . $direction);
        } else {
            $query->orderBy($sort, $direction);
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

    // public function submit(Request $request)
    // {
    //     // dd($request->all());
    //     // Validation rules
    //     $arr_rules = 
    //     [
    //         'profile_image' => 'nullable',
    //         'first_name' => 'required|max:100',
    //         'middle_name' => 'nullable|max:100',
    //         'last_name' => 'required|max:100',
    //         'dob' => 'required|date',
    //         'gender' => 'required|string',
    //         'email' => 'required|email',
    //         'mobile' => 'required|digits:10',
    //         'residence_address' => 'required|string',
    //         'residence_area' => 'nullable|string',
    //         'zipcode' => 'required|digits:6',
    //         'city' => 'required|string',
    //         'state' => 'required|string',
    //         'country' => 'required|string',
    
    //         'membership_type' => 'required|int',
    //         'joining_date' => 'required|date',
    //         'expiry_date' => 'required|date',
    //         'amount_paid' => 'required|numeric',
    //         'payment_method' => 'required|string',
    //         'trainer_assigned' => 'required|string',
    
    //         'fitness_goals' => 'required|string',
    //         'preferred_workout_time' => 'required|string',
    //         'current_weight' => 'nullable|numeric',
    //         'additional_notes' => 'nullable|string',
    //     ];
    
    //     // Validate the inputs
    //     $validator = Validator::make($request->all(), $arr_rules);
    //     // dd($validator);
    
    //     if ($validator->fails()) 
    //     {
    //         $arr_resp['status'] = 'error';
    //         $arr_resp['message'] = $validator->messages();
    //         return response()->json($arr_resp, 400);
    //     }
    
    //     DB::beginTransaction();
    
    //     try 
    //     {
    //         // dd(1);
    //         // Insert all request data exactly as received

    //         $user_details_arr = $request->all();
    //         // dd( $user_details_arr);

            
    //         if ($request->hasFile('profile_image')) 
    //         {
    //             $image = $request->file('profile_image');
    //             $imageName = time().'_'.$image->getClientOriginalName();
    //             $image->move(public_path('uploads/profile_images'), $imageName);
    //             $user_details_arr['profile_image'] = 'uploads/profile_images/' . $imageName;
    //         } 
    //         elseif ($request->filled('profile_image')) {
    //             // If the input is a full URL, extract only the path
    //             $imagePath = $request->input('profile_image');
    //             $imagePath = parse_url($imagePath, PHP_URL_PATH); // removes domain
    //             $imagePath = ltrim($imagePath, '/'); // remove leading slash if any
    //             $user_details_arr['profile_image'] = $imagePath;
    //         } else {
    //             $user_details_arr['profile_image'] = null;
    //         }
    
    //         $inserted_id = DB::table('tbl_gym_members')->insertGetId($user_details_arr);
    //         // Create user for login
    //         $full_name = $request->first_name . ' ' . $request->last_name;

    //         DB::table('users')->insert([
    //             'name' => $full_name,
    //             'email' => $request->email,
    //             'password' => Hash::make('123456'),
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //         DB::commit();
    
    //         $arr_resp['status'] = 'success';
    //         $arr_resp['message'] = 'Member added successfully';
    //         $arr_resp['member_id'] = $inserted_id;
    //         return response()->json($arr_resp);
    
    //     } 
    //     catch (\Exception $e) 
    //     {
    //         DB::rollback();
    //         Log::error($e->getMessage());
    
    //         $arr_resp['status'] = 'error';
    //         $arr_resp['message'] = $e->getMessage();
    //         return response()->json($arr_resp, 500);
    //     }
    // }
    public function submit(Request $request)
{
    // Validation rules
    $arr_rules = [
        'profile_image' => 'nullable',
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

    $validator = Validator::make($request->all(), $arr_rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->messages()
        ], 400);
    }

    DB::beginTransaction();

    try {
        $user_details_arr = $request->all();

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/profile_images'), $imageName);
            $user_details_arr['profile_image'] = 'uploads/profile_images/' . $imageName;
        } elseif ($request->filled('profile_image')) {
            $imagePath = parse_url($request->input('profile_image'), PHP_URL_PATH);
            $imagePath = ltrim($imagePath, '/');
            $user_details_arr['profile_image'] = $imagePath;
        } else {
            $user_details_arr['profile_image'] = null;
        }

        $inserted_id = DB::table('tbl_gym_members')->insertGetId($user_details_arr);

        $full_name = $request->first_name . ' ' . $request->last_name;
        DB::table('users')->insert([
            'name' => $full_name,
            'email' => $request->email,
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Member added successfully',
            'member_id' => $inserted_id
        ]);

    } catch (\Illuminate\Database\QueryException $e) {
        DB::rollback();
        Log::error($e->getMessage());

        $errorMessage = $e->getMessage();

        // Check for duplicate email or mobile
        if (str_contains($errorMessage, 'tbl_gym_members_email_unique')) {
            $friendlyMessage = 'Integrity constraint: Email cannot be duplicate';
        } elseif (str_contains($errorMessage, 'tbl_gym_members_mobile_unique')) {
            $friendlyMessage = 'Integrity constraint: Mobile cannot be duplicate';
        } else {
            $friendlyMessage = $errorMessage;
        }

        return response()->json([
            'status' => 'error',
            'message' => $friendlyMessage
        ], 500);
    } catch (\Exception $e) {
        DB::rollback();
        Log::error($e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}


    public function edit($id)
    {
        try 
        {
            $member = DB::table('tbl_gym_members')->where('id', $id)->first();
            // dd($member);
            $memberships = DB::table('tbl_gym_membership')
            ->where('is_active', 1)       // same as add()
            ->pluck('membership_name', 'id'); // id => name array

            $trainer = DB::table('tbl_trainer')
            ->where('is_active', 1)
            ->pluck('trainer_name', 'id');
            // dd($memberships);
            if (!$member) 
            {
                // dd("Page not found");
                return redirect()->back()->with('error', 'Member not found!');
            }
    
            return view('tabs.index', compact('member','memberships','trainer'));
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
        // dd(12);
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

    public function update_profile(Request $request, $id)
    {
        // dd(1);
        $arr_rules = [
            'first_name'        => 'required|string',
            'middle_name'       => 'nullable|string',
            'last_name'         => 'required|string',
            'dob'               => 'required|date',
            'gender'            => 'required|string',
            'email'             => 'required|email',
            'mobile'            => 'required|string',
            'residence_address' => 'required|string',
            'residence_area'    => 'required|string',
            'zipcode'           => 'required|string',
            'city'              => 'required|string',
            'state'             => 'required|string',
            'country'           => 'required|string',
        ];

        $validator = Validator::make($request->all(), $arr_rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->messages()
            ], 400);
        }

        DB::beginTransaction();

        try {
            $user_details_arr = $request->except(['_token']); // exclude token

            $existing = DB::table('tbl_gym_members')->where('id', $id)->first();

            // ✅ CASE 1: File directly uploaded
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img/profile_image'), $imageName);
                $user_details_arr['profile_image'] = 'assets/img/profile_image/' . $imageName;
            } 
            // ✅ CASE 2: Cropped image path is sent in payload (already stored on server)
            elseif ($request->filled('profile_image')) {
                $user_details_arr['profile_image'] = $request->input('profile_image');
            } 
            // ✅ CASE 3: Keep existing image if no change
            else {
                $user_details_arr['profile_image'] = $existing->profile_image ?? null;
            }

            // Update record
            $updated = DB::table('tbl_gym_members')
                ->where('id', $id)
                ->update($user_details_arr);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => $updated ? 'Member updated successfully' : 'No changes made',
                'id'      => $id
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update_setings(Request $request, $id)
    {
        // Validation rules (only the fields that are required)
        $arr_rules = [
            'fitness_goals'          => 'required|string',
            'preferred_workout_time' => 'required|string',
            'current_weight'         => 'nullable|numeric',
            'additional_notes'       => 'nullable|string',
        ];
    
        // Validate the inputs
        $validator = Validator::make($request->all(), $arr_rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->messages()
            ], 400);
        }
    
        DB::beginTransaction();
    
        try {
            // Prepare only the fields we want to update
            $member_data = $request->only([
                'fitness_goals', 
                'preferred_workout_time', 
                'current_weight', 
                'additional_notes'
            ]);
    
            // Update the existing member record by ID
            $updated = DB::table('tbl_gym_members')
                ->where('id', $id)
                ->update($member_data);
    
            DB::commit();
    
            return response()->json([
                'status'  => 'success',
                'message' => $updated ? 'Member updated successfully' : 'No record updated',
                'id'      => $id
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'status'  => 'error',
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
