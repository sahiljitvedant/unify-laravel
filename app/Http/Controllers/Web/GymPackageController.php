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
use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth; 
use App\Models\Membership;
use App\Models\GymMember;
use App\Models\Payment; 
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\PaymentEmailService;
use App\Imports\ImportUsersExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\PaymentCompleted;

class GymPackageController extends Controller
{
    public function list()
    {
        return view('gym_packages.list');
    }

    public function import_members(Request $request)
    {
        // dd(1);
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new ImportUsersExcel, $request->file('excel_file'));

        return redirect()->back()->with('success', 'Users imported successfully to tbl_import_users!');
    }
    public function list_deleted_member()
    {
        // dd(1);
        return view('gym_packages.list_deleted_member');

    }
    public function fetchMemberList(Request $request)
    {
        // dd(1);
        // dd($request->all());
        $query = GymMember::with(['membership', 'user'])
        ->where('is_deleted', '!=', 9)
        ->whereHas('user', function ($q) {
            $q->where('is_admin', '=', 1);
        });

        // dd($query);

        // Apply filters
        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', "%{$request->first_name}%");
        }
    
        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', "%{$request->mobile}%");
        }
    
        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->email}%");
        }
    
        if ($request->filled('membership_type')) {
            $query->where('membership_type', $request->membership_type);
        }
        // Sorting
        $allowedSorts = [
            'id', 'first_name', 'email', 'mobile', 'membership_type', 'amount_paid'
        ];
    
        
        $sort = $request->get('sort', 'id');
        $direction = $request->get('order', 'desc');

        if (!in_array($sort, $allowedSorts)) $sort = 'id';
        if (!in_array(strtolower($direction), ['asc', 'desc'])) $direction = 'desc';
    
        $query->orderBy($sort, $direction);

        // Pagination
        $memberships = $query->paginate(10);
        // dd( $memberships);
        // Add action + encrypted_id
        // $memberships->getCollection()->transform(function ($row) {
        //     $encryptedId = Crypt::encryptString($row->id);
        //     $row->encrypted_id = $encryptedId;
        //     $row->action = '
        //         <a href="'.route('edit_admin_member', $row->id).'" class="btn btn-sm" title="Edit">
        //             <i class="bi bi-pencil-square"></i>
        //         </a>
        //         <a href="'.route('change_member_password', $row->id).'" class="btn btn-sm" title="Password">
        //             <i class="bi bi-eye"></i>
        //         </a>
        //         <button type="button" class="btn btn-sm" onclick="approve_member('.$row->id.')">
        //             <i class="bi bi-check-circle text-success"></i>
        //         </button>
        //         <button type="button" class="btn btn-sm" onclick="delete_members('.$row->id.')">
        //             <i class="bi bi-trash"></i>
        //         </button>';
        //     return $row;
        // });
        // $memberships->getCollection()->transform(function ($row) {
        //     $encryptedId = Crypt::encryptString($row->id);
        //     $row->encrypted_id = $encryptedId;
        
        //     $actions = '<div class="d-flex flex-column gap-1">'; // start vertical stack
        
        //     // Edit
        //     $actions .= '
        //         <a href="'.route('edit_admin_member', $row->id).'" class="btn btn-sm" title="Edit">
        //             <i class="bi bi-pencil-square"></i>
        //         </a>
        //     ';
        
        //     // Password
        //     $actions .= '
        //         <a href="'.route('change_member_password', $row->id).'" class="btn btn-sm" title="Password">
        //             <i class="bi bi-eye"></i>
        //         </a>
        //     ';
        
        //     // Delete
        //     $actions .= '
        //         <button type="button" class="btn btn-sm" onclick="delete_members('.$row->id.')">
        //             <i class="bi bi-trash"></i>
        //         </button>
        //     ';
        
        //     // Approve (only if admin_approved = 0)
        //     if ($row->admin_approved == 0) {
        //         $actions .= '
        //             <button type="button" class="btn btn-sm" onclick="approve_member('.$row->id.')">
        //                 <i class="bi bi-check-circle text-success"></i>
        //             </button>
        //         ';
        //     }
        
        //     $actions .= '</div>'; // close vertical stack
        
        //     $row->action = $actions;
        
        //     return $row;
        // });
        $memberships->getCollection()->transform(function ($row) {
            $encryptedId = Crypt::encryptString($row->id);
            $row->encrypted_id = $encryptedId;
        
            // Dropdown with three dots
            $actions = '
            <div class="dropdown text-center">
                <button class="btn btn-sm btn-light p-0" type="button" id="actionMenu'.$row->id.'" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu " aria-labelledby="actionMenu'.$row->id.'" style="min-width: auto;">
                   
                    <li>
                        <a class="dropdown-item d-inline-flex align-items-center justify-content-center" href="'.route('change_member_password', $row->id).'" title="Password">
                            <i class="bi bi-eye"></i>
                        </a>
                    </li>';
        
                    if ($row->admin_approved == 0) {
                        $actions .= '
                            <li>
                                <button class="dropdown-item d-inline-flex align-items-center justify-content-center" onclick="approve_member('.$row->id.')" title="Approve">
                                    <i class="bi bi-check-circle "></i>
                                </button>
                            </li>';
                    }
                
                    $actions .= '
                            <li>
                                <button class="dropdown-item d-inline-flex align-items-center justify-content-center" onclick="delete_members('.$row->id.')" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </li>
                        </ul>
                    </div>';
        
            $row->action = $actions;
        
            return $row;
        });
        return response()->json($memberships);
    }


    public function fetch_member_list_pending_payment(Request $request)
    {
        try {
            $query = Payment::with(['user', 'membership'])
                ->where('total_amount_remaining', '>', 0)
                ->where('payment_status', 1); // only pending payments
    
            // Sorting
            $sort = $request->get('sort', 'id');
            $direction = strtolower($request->get('order', 'desc')) === 'asc' ? 'asc' : 'desc';
    
            // Handle relational/computed columns sorting
            if ($sort === 'name') {
                $query->join('tbl_users as u', 'tbl_payments.user_id', '=', 'u.id')
                      ->select('tbl_payments.*')
                      ->orderBy('u.name', $direction);
            } elseif ($sort === 'email') {
                $query->join('tbl_users as u', 'tbl_payments.user_id', '=', 'u.id')
                      ->select('tbl_payments.*')
                      ->orderBy('u.email', $direction);
            } elseif ($sort === 'price') {
                $query->join('tbl_gym_membership as m', 'tbl_payments.plan_id', '=', 'm.id')
                      ->select('tbl_payments.*')
                      ->orderBy('m.price', $direction);
            } elseif ($sort === 'amount_paid') {
                $query->orderBy('tbl_payments.total_amount_paid', $direction);
            } elseif ($sort === 'fees_pending') {
                $query->orderBy('tbl_payments.total_amount_remaining', $direction);
            } else {
                $query->orderBy('tbl_payments.id', $direction);
            }
    
            // Paginate
            $payments = $query->paginate(10);
    
            // Keep only latest payment per cycle to avoid duplicate pending entries
            $latestPayments = $payments->getCollection()
                ->sortByDesc('id')      // latest first
                ->unique('cycle_id')    // one per cycle
                ->values();
    
            // Replace paginator collection with filtered items
            $payments->setCollection($latestPayments);
    
            // Map data for frontend
            $data = $payments->getCollection()->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => optional($p->user)->name ?? 'N/A',
                    'email' => optional($p->user)->email ?? 'N/A',
                    'membership_name' => optional($p->membership)->membership_name ?? 'N/A',
                    'price' => optional($p->membership)->price ?? 0,
                    'amount_paid' => $p->total_amount_paid ?? 0,
                    'remaining_amount' => $p->total_amount_remaining ?? 0,
                ];
            });
    
            $payments->setCollection($data);
    
            return response()->json([
                'status' => 'success',
                'data' => $payments->items(),
                'current_page' => $payments->currentPage(),
                'last_page' => $payments->lastPage(),
                'per_page' => $payments->perPage(),
                'total' => $payments->total(),
            ]);
    
        } catch (\Exception $e) {
            Log::error('Fetch pending payment members failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong while fetching pending payments.'
            ], 500);
        }
    }
    
    public function fetchDeletedMemberList(Request $request)
    {
        // dd(1);
        // dd($request->all());
        $query = GymMember::with('membership')
        ->where('is_deleted', '=', 9);

        // dd($query);

        // Apply filters
        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', "%{$request->first_name}%");
        }
    
        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', "%{$request->mobile}%");
        }
    
        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->email}%");
        }
    
        if ($request->filled('membership_type')) {
            $query->where('membership_type', $request->membership_type);
        }
        // Sorting
        $allowedSorts = [
            'id', 'first_name', 'email', 'mobile', 'membership_type', 'amount_paid'
        ];
    
        
        $sort = $request->get('sort', 'id');
        $direction = $request->get('order', 'desc');

        if (!in_array($sort, $allowedSorts)) $sort = 'id';
        if (!in_array(strtolower($direction), ['asc', 'desc'])) $direction = 'desc';
    
        $query->orderBy($sort, $direction);

        // Pagination
        $memberships = $query->paginate(10);
        // dd( $memberships);
        // Add action + encrypted_id
        $memberships->getCollection()->transform(function ($row) {
            $encryptedId = Crypt::encryptString($row->id);
            $row->encrypted_id = $encryptedId;
            $row->action = '
            <button type="button" class="btn btn-sm" onclick="activateMembershipID('.$row->id.')">
            <i class="bi bi-check-circle"></i>
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
            // dd($id);
            // $user = Auth::user(); 
            // dd($user);
            $member = GymMember::where('user_id', $id)->first();
            // dd($member);
            $latestPayment = Payment::where('user_id', $id)
            ->with('membership') // optional if you need membership name/price
            ->latest()
            ->first();
            if (!$member) {
                return redirect()->back()->with('error', 'Member not found!');
            }
            // dd($latestPayment);
            // ✅ Restrict access (only the logged-in user can edit their own member profile)
            // if ($member->user_id !== $user->id) {
            //     // abort(403, 'Unauthorized access.');
            //     return view('access_denied');
            // }
            $memberships = DB::table('tbl_gym_membership')
            ->where('is_active',"1")     
            ->select('id', 'membership_name', 'trainer_included')
            ->get();

            $trainer = DB::table('tbl_trainer')
            ->where('is_active', 1)
            ->pluck('trainer_name', 'id');
            // dd($memberships);
           
            $userPreferences = UserPreference::with('preference')
            ->where('user_id', $member->user_id)
            ->get();

            // dd($userPreferences);
            return view('tabs.index', compact('member','memberships','trainer','userPreferences','latestPayment'));
        } 
        catch (\Exception $e)
        {
            // dd($e->getMessage());
            Log::error('Edit member failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching the member.');
        }
    }
    public function edit_admin($id)
    {
        // dd($id);
        try 
        {

            $member = DB::table('tbl_gym_members')->where('id', $id)->first();
            // dd($member);

            if (!$member) {
                // dd(1);
                return redirect()->back()->with('error', 'Member not found!');
            }
            if ($member->is_deleted == 9) {
                // dd(1);
                return redirect()->back()->with('error', 'This member cannot be edited (status inactive/deleted).');
            }
           
            $latestPayment = Payment::where('user_id', $id)
            ->with('membership') // optional if you need membership name/price
            ->latest()
            ->first();
            // dd($member);
            $memberships = DB::table('tbl_gym_membership')
            ->where('is_active',"1")     
            ->select('id', 'membership_name', 'trainer_included')
            ->get();
        
            $trainer = DB::table('tbl_trainer')
            ->where('is_active', 1)
            ->pluck('trainer_name', 'id');
            // dd($memberships);
            if (!$member) 
            {
                // dd("Page not found");
                return redirect()->back()->with('error', 'Member not found!');
            }
            $user = User::find($member->user_id);
            // dd($user);
            return view('member_admin_edit.index', compact('member','memberships','trainer','latestPayment','user'));
        } 
        catch (\Exception $e)
        {
            // dd($e->getMessage());
            Log::error('Edit member failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching the member.');
        }
    }

    public function change_member_password($id)
    {
        // dd($id);
        $member = DB::table('tbl_gym_members')->where('id', $id)->first();
        $user = User::find($member->user_id);

        return view('member_admin_edit.password', compact('member'));

    }
    public function update_member_password(Request $request)
{
    $request->validate([
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::findOrFail($request->user_id);

    $user->password = Hash::make($request->password);
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Password updated successfully!',
    ]);
}

    public function update(Request $request,$id)
    {
        // dd(12);
        // dd($request->all());
        // Validation rules
        $arr_rules = 
        [
            'membership_type' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'amount_paid' => 'nullable|numeric',
            'payment_method' => 'nullable|string',
            'trainer_assigned' => 'nullable|string',
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

            $user_details_arr = $request->all();
            // dd( $user_details_arr);

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

        }catch (\Exception $e) {
            DB::rollBack();
        
            $message = 'Update failed: ' . $e->getMessage();
        
            if ($e->getCode() == 23000) {
                // Check which unique index caused the duplicate
                if (strpos($e->getMessage(), 'tbl_gym_members_email_unique') !== false) {
                    $message = 'The email you entered is already taken.';
                } elseif (strpos($e->getMessage(), 'tbl_gym_members_mobile_unique') !== false) {
                    $message = 'The mobile number you entered is already taken.';
                } else {
                    $message = 'Duplicate entry detected.';
                }
            }
        
            return response()->json([
                'status' => 'error',
                'message' => $message
            ], 500);
        }
        
        
    }
    public function update_setings(Request $request, $id)
    {
        // dd($id);
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
            return response()->json(['status' => false, 'message' => 'Member not found'], 404);
        }

        DB::table('tbl_gym_members')
        ->where('id', $id)
        ->update([
            'is_deleted' => 9,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Member deleted successfully'
        ]);
    }

    public function approve_member($id)
    {
        // dd(1);
        $membership = DB::table('tbl_gym_members')->where('id', $id)->first();
        // dd($membership);
        if (!$membership) 
        {
            return response()->json(['status' => false, 'message' => 'Member not found'], 404);
        }

        DB::table('tbl_gym_members')
        ->where('id', $id)
        ->update([
            'admin_approved' =>"1",  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Member approved successfully'
        ]);
    }
    public function activate_member ($id)
    {
        // dd(1);
        $members = DB::table('tbl_gym_members')->where('id', $id)->first();
        // dd($members);
        if (!$members) 
        {
            return response()->json(['status' => false, 'message' => 'member not found'], 404);
        }

        DB::table('tbl_gym_members')
        ->where('id', $id)
        ->update([
            'is_deleted' => 1,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Members activated successfully'
        ]);
    }
    // Members Payment:-
    public function member_payment($id)
    {
        // dd($id);
        try 
        {
            return view('gym_packages.member_payment',compact('id'));
     
        } 
        catch (\Exception $e)
        {
            // dd($e->getMessage());
            Log::error('No Payment Found: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching the member.');
        }
    }


    public function fetch_member_payment(Request $request, $id)
    {
        try {
            $query = Payment::where('user_id', $id)
                ->with(['membership', 'user', 'doneByUser']);
    
            // Filters
            
            if ($request->filled('membership_id')) {
                $query->where('plan_id', $request->membership_id);
            }
    
            // Sorting
            $sortColumn = $request->get('sort', 'id');
            $sortOrder = $request->get('order', 'asc');
    
            // Only allow specific columns for safety
            $allowedSort = ['id', 'amount', 'total_amount_paid', 'total_amount_remaining', 'created_at'];
            if (!in_array($sortColumn, $allowedSort)) {
                $sortColumn = 'id';
            }
    
            $payments = $query->orderBy($sortColumn, $sortOrder)
                ->paginate(10);
            $payments->getCollection()->transform(function ($payment) {
                $payment->encrypted_id = Crypt::encryptString($payment->id);
                return $payment;
            });
        
            return response()->json($payments);
        } catch (\Exception $e) {
            \Log::error('Error fetching member payments: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong while fetching payments.'], 500);
        }
    }
    
    public function add_member_payment($id)
    {
        // dd($id);
        $membership = Membership::where('is_active', "1")
        ->where('is_deleted',"0")
        ->get();

        // dd($membership);
        $latestPayment = DB::table('tbl_payments')
            ->where('user_id', $id)
            ->latest('id')
            ->first();

        $pendingPayment = null;

        if ($latestPayment && $latestPayment->total_amount_remaining > 0) 
        {
            $pendingPayment = $latestPayment;
        }
        return view('gym_packages.add_payment',compact('membership','id','pendingPayment'));
    }

    public function getRemainingBalance(Request $request)
    {
        $userId = $request->user_id;
        $planId = $request->membership_id;
    
        // Get membership price
        $membership = Membership::find($planId);
        $membershipPrice = $membership ? $membership->price : 0;
    
        // Get latest payment for this user & plan
        $latestPayment = Payment::where('user_id', $userId)
            ->where('plan_id', $planId)
            ->orderBy('id', 'desc')
            ->first();
    
        // If user has a payment with pending balance → return that
        if ($latestPayment && $latestPayment->total_amount_remaining > 0) {
            return response()->json([
                'remaining' => $latestPayment->total_amount_remaining
            ]);
        }
    
        return response()->json([
            'remaining' => $membershipPrice
        ]);
    }
    
    // public function submit_member_payment(Request $request, $id)
    // {
    //     $request->validate([
    //         'membership_id' => 'required|integer',
    //         'price' => 'required|numeric|min:50',
    //         'user_id' => 'required|integer',
    //         'discount' => 'required|numeric|min:0',
    //         'membership_start_date' => 'required|date',
    //         'membership_end_date' => 'required|date|after_or_equal:membership_start_date',
    //         'payment_method' => 'required|in:1,2,3',
    //     ]);

    //     $membership = Membership::find($request->membership_id);
    //     if (!$membership) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Membership not found'
    //         ]);
    //     }

    //     // Get last payment for this user + membership
    //     $lastPayment = Payment::where('user_id', $request->user_id)
    //         ->where('plan_id', $request->membership_id)
    //         ->latest()
    //         ->first();

    //     // Determine cycle ID
    //     if ($lastPayment && $lastPayment->total_amount_remaining == 0) {
    //         // Last membership fully paid → start a new cycle
    //         $cycleId = uniqid('cycle_id');
    //     } elseif ($lastPayment) {
    //         // Continue same cycle
    //         $cycleId = $lastPayment->cycle_id ?? uniqid('cycle_id');
    //     } else {
    //         // First purchase ever
    //         $cycleId = uniqid('cycle_id');
    //     }

    //     $currentAmount = $request->price;
    //     $currentDiscount = $request->discount ?? 0;

    //     // Total paid so far in this cycle (excluding current)
    //     $previousPaid = Payment::where('user_id', $request->user_id)
    //         ->where('plan_id', $request->membership_id)
    //         ->where('cycle_id', $cycleId)
    //         ->sum('amount');

    //     // Total discount so far in this cycle (excluding current)
    //     $previousDiscount = Payment::where('user_id', $request->user_id)
    //         ->where('plan_id', $request->membership_id)
    //         ->where('cycle_id', $cycleId)
    //         ->sum('discount');

    //     // Add current payment + discount
    //     $totalPaid = $previousPaid + $currentAmount;
    //     $totalDiscount = $previousDiscount + $currentDiscount;

    //     // Calculate remaining
    //     $remaining = max($membership->price - $totalPaid - $totalDiscount, 0);

    //     // Determine payment status for current payment
    //     $paymentStatus = $remaining == 0 ? 2 : 1;

    //     // Generate invoice number
    //     $invoiceNumber = 'MEM' . $request->user_id . '-' . rand(100, 999) . '-' . now()->format('dMMy');

    //     // Insert current payment
    //     $payment = Payment::create([
    //         'user_id' => $request->user_id,
    //         'plan_id' => $request->membership_id,
    //         'cycle_id' => $cycleId,
    //         'amount' => $currentAmount,
    //         'discount' => $currentDiscount,
    //         'membership_start_date' => $request->membership_start_date,
    //         'membership_end_date' => $request->membership_end_date,
    //         'payment_done_by' => auth()->id() ?? $id,
    //         'invoice_number' => $invoiceNumber,
    //         'total_amount_paid' => $totalPaid,
    //         'total_amount_remaining' => $remaining,
    //         'payment_status' => $paymentStatus,
    //         'payment_method' => $request->payment_method,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     // ✅ If fully paid, update all previous payments in this cycle to status 2
    //     if ($remaining == 0) {
    //         Payment::where('user_id', $request->user_id)
    //             ->where('plan_id', $request->membership_id)
    //             ->where('cycle_id', $cycleId)
    //             ->update(['payment_status' => 2]);
    //     }

    //     // Update member info
    //     GymMember::updateOrCreate(
    //         ['user_id' => $id],
    //         [
    //             'membership_type' => $request->membership_id,
    //             'joining_date' => $request->membership_start_date,
    //             'expiry_date' => $request->membership_end_date,
    //             'payment_method' => $request->payment_method,
    //             'amount_paid'=> $totalPaid,
    //             'manual_payment_flag'=>"1",
    //             'cron_flag'=>"1"
    //         ]
    //     );

    //     // Generate PDF invoice
    //     $pdf = PDF::loadView('gym_packages.invoice_pdf', ['payment' => $payment]);
    //     $fileName = 'invoice_' . $payment->invoice_number . '.pdf';
    //     $path = 'public/invoices/' . $fileName;
    //     Storage::put($path, $pdf->output());
    //     $payment->update(['invoice_path' => 'storage/invoices/' . $fileName]);

    //     $email = 'sahilsunilj@gmail.com';
    //     PaymentEmailService::sendInvoice($payment, 'storage/invoices/' . $fileName, $email);

    //     return response()->json([
    //         'status'  => 'success',
    //         'payment' => $payment,
    //         'pdf_url' => asset('storage/invoices/' . $fileName),
    //         'total_paid' => $totalPaid,
    //         'remaining' => $remaining
    //     ]);
    // }

    public function submit_member_payment(Request $request, $id)
    {
        $request->validate([
            'membership_id' => 'required|integer',
            'price' => 'required|numeric|min:50',
            'user_id' => 'required|integer',
            'discount' => 'required|numeric|min:0',
            'membership_start_date' => 'required|date',
            'membership_end_date' => 'required|date|after_or_equal:membership_start_date',
            'payment_method' => 'required|in:1,2,3',
        ]);

        $membership = Membership::find($request->membership_id);
        if (!$membership) {
            return response()->json([
                'status' => 'error',
                'message' => 'Membership not found'
            ]);
        }

        // Get last payment for this user + membership
        $lastPayment = Payment::where('user_id', $request->user_id)
            ->where('plan_id', $request->membership_id)
            ->latest()
            ->first();

        // Determine cycle ID
        if ($lastPayment && $lastPayment->total_amount_remaining == 0) {
            // Last membership fully paid → start a new cycle
            $cycleId = uniqid('cycle_id');
        } elseif ($lastPayment) {
            // Continue same cycle
            $cycleId = $lastPayment->cycle_id ?? uniqid('cycle_id');
        } else {
            // First purchase ever
            $cycleId = uniqid('cycle_id');
        }

        $currentAmount = $request->price;
        $currentDiscount = $request->discount ?? 0;

        // Total paid so far in this cycle (excluding current)
        $previousPaid = Payment::where('user_id', $request->user_id)
            ->where('plan_id', $request->membership_id)
            ->where('cycle_id', $cycleId)
            ->sum('amount');

        // Total discount so far in this cycle (excluding current)
        $previousDiscount = Payment::where('user_id', $request->user_id)
            ->where('plan_id', $request->membership_id)
            ->where('cycle_id', $cycleId)
            ->sum('discount');

        // Add current payment + discount
        $totalPaid = $previousPaid + $currentAmount;
        $totalDiscount = $previousDiscount + $currentDiscount;

        // Calculate remaining
        $remaining = max($membership->price - $totalPaid - $totalDiscount, 0);

        // Determine payment status for current payment
        $paymentStatus = $remaining == 0 ? 2 : 1;

        // Generate invoice number
        $invoiceNumber = 'MEM' . $request->user_id . '-' . rand(100, 999) . '-' . now()->format('dMMy');

        // Insert current payment
        $payment = Payment::create([
            'user_id' => $request->user_id,
            'plan_id' => $request->membership_id,
            'cycle_id' => $cycleId,
            'amount' => $currentAmount,
            'discount' => $currentDiscount,
            'membership_start_date' => $request->membership_start_date,
            'membership_end_date' => $request->membership_end_date,
            'payment_done_by' => auth()->id() ?? $id,
            'invoice_number' => $invoiceNumber,
            'total_amount_paid' => $totalPaid,
            'total_amount_remaining' => $remaining,
            'payment_status' => $paymentStatus,
            'payment_method' => $request->payment_method,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ✅ If fully paid, update all previous payments in this cycle to status 2
        if ($remaining == 0) {
            Payment::where('user_id', $request->user_id)
                ->where('plan_id', $request->membership_id)
                ->where('cycle_id', $cycleId)
                ->update(['payment_status' => 2]);
        }

        // Update member info
        GymMember::updateOrCreate(
            ['user_id' => $id],
            [
                'membership_type' => $request->membership_id,
                'joining_date' => $request->membership_start_date,
                'expiry_date' => $request->membership_end_date,
                'payment_method' => $request->payment_method,
                'amount_paid'=> $totalPaid,
                'manual_payment_flag'=>"1",
                'cron_flag'=>"1"
            ]
        );

        // Generate PDF invoice
        // $pdf = PDF::loadView('gym_packages.invoice_pdf', ['payment' => $payment]);
        // $fileName = 'invoice_' . $payment->invoice_number . '.pdf';
        // $path = 'public/invoices/' . $fileName;
        // Storage::put($path, $pdf->output());
        // $payment->update(['invoice_path' => 'storage/invoices/' . $fileName]);

        // $email = 'sahilsunilj@gmail.com';
        // PaymentEmailService::sendInvoice($payment, 'storage/invoices/' . $fileName, $email);
        event(new PaymentCompleted($payment));

        return response()->json([
            'status'  => 'success',
            'payment' => $payment,
            // 'pdf_url' => asset('storage/invoices/' . $fileName),
            'total_paid' => $totalPaid,
            'remaining' => $remaining
        ]);
    }
    public function list_payment()
    { 
        $users = User::where('is_admin', 0) ->orderBy('name', 'asc')->get(); 
        $membership = Membership::where('is_active', "1")
        ->where('is_deleted',"0")
        ->get();
        return view('gym_packages.list_payment', compact('users','membership'));
    }
    public function view_admin_invoice($encId)
    {
        // dd($encId);
        try {
            $id = Crypt::decryptString($encId);
            // dd($id); 
            $payment = Payment::with(['membership', 'user', 'doneByUser'])
            ->findOrFail($id);
            // dd($payment);
            return view('gym_packages.view_invoice', compact('payment'));
     
        } 
        catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Invalid ID');
        }
    }

}
