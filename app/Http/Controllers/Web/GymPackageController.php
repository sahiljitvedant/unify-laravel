<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables; 

class GymPackageController extends Controller
{
    public function list()
    {
        return view('gym_packages.list');
    }

    public function fetchMemberList(Request $request)
{
    // ONE variable that fetches everything you need
    $fetch_data = DB::table('tbl_gym_members')
        ->select('id','membership_type','joining_date','expiry_date','amount_paid','payment_method','trainer_assigned');

    // Send to DataTables (server-side)
    return DataTables::of($fetch_data)
        ->addColumn('action', function ($row) {
            return '<a href="/members/edit/'.$row->id.'" class="btn btn-sm btn-primary">Edit</a>
                    <a href="/members/delete/'.$row->id.'" class="btn btn-sm btn-danger">Delete</a>';
        })
        ->rawColumns(['action'])
        ->make(true);
}
    
    public function add()
    {
        return view('gym_packages.add_form');
    }

    public function submit(Request $request)
    {
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
    
            'membership_type' => 'required|string',
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
    public function add_guest_family_member(Request $request)
    {
        $is_admin=0;
        $guard = \Session::get('guard');
        if($guard=='admin')
        {
            $is_admin=1;
        }
        $created_by =  Auth::guard($guard)->user()->id;
        $userDetails = $request->input();
        //$parent_id = ($is_admin==1)?$userDetails['primary_member_id']:Auth::guard($guard)->user()->id;
        $parent_id = Auth::guard($guard)->user()->id;
        $parent_Details = User::where('status','1')->where('id',$parent_id)->get();
        
        if($is_admin==1)
        {
            $parent_id =$userDetails['primary_member_id'];
        }
        else if($parent_Details && $parent_Details[0]->parent_id > 0)
        {
            $parent_id =$parent_Details[0]->parent_id;
        }
       
        $arr_rules = array();
        
        $relation = $request->input('relation');

        $arr_rules['primary_member'] = ($is_admin==1)?"required":"";
        $arr_rules['first_name'] = "required|max:100";
        $arr_rules['middle_name'] = "required|max:100";
        $arr_rules['last_name'] = "required|max:100";
        $arr_rules['occupation'] = "required";
        $arr_rules['native_district'] = "required";
        $arr_rules['native_place'] = "required";
        // $arr_rules['blood_group'] = "required";
        $arr_rules['education_levels'] = 'required';
        // $arr_rules['marital_status'] = "required";
        // $arr_rules['association_ids'] = "required";
        // $arr_rules['is_approved'] = "accepted";
        $arr_rules['last_degree'] = "required|max:255";
        if($relation=='Spouse'){

            $arr_rules['email'] = "required|max:150|email";
            $arr_rules['country_code'] = "required";
            $arr_rules['mobile'] = "required|numeric";
       
        }
       
        // $arr_rules['company_name'] = "required|max:100";
        // $arr_rules['zip_code'] = "required";
        $arr_rules['address1'] = "max:150";
        $arr_rules['address2'] = "max:150";
     
        $arr_rules['image'] = 'image|max:1024';
        $arr_rules['business_image'] = 'image|max:1024';
        $arr_rules['professional_image'] = 'image|max:1024';
        $customMessages = [
            'image.image' => trans('profile.profile_image_supported_type'),
            'image.max' => trans('profile.profile_image_max'),
            'business_image.image' => trans('profile.profile_image_supported_type'),
            'business_image.max' => trans('profile.profile_image_max'),
            'professional_image.image' => trans('profile.profile_image_supported_type'),
            'professional_image.max' => trans('profile.profile_image_max'),
        ];
     
        //validate the inputs 
        $validator = validator::make($request->all(),$arr_rules);
        
        if ($validator->fails())
        {
        
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = $validator->messages();
            return response()->json($arr_resp, 400);
            
        }

        $action_id = $request->input('action_id');
        $relation = $userDetails['relation'];
        $parameter = $this->get_subscription_paramters_values($parent_id,$relation,$action_id);
       
        DB::beginTransaction();

        try{

            $mobile_exists = User::where('status','!=','9')->where('mobile',$userDetails['mobile'])->where('mobile', '!=', '')->whereNotNull('mobile')->exists();

            if($mobile_exists){
                $arr_resp['status'] = 'error';
                $arr_resp['message'] =  trans('familymember.mobile_error_unique');;
                return response()->json($arr_resp, 400);
            }

            $email_exists = User::where('status','!=','9')->where('email',$userDetails['email'])->where('email', '!=', '')->whereNotNull('email')->exists();

            if($email_exists){
                $arr_resp['status'] = 'error';
                $arr_resp['message'] = trans('familymember.email_error_unique');
                return response()->json($arr_resp, 400);
            }

            $user_table_arr['aahoa_id'] =  get_next_aahoa_id();//$userDetails['1'];
            $user_table_arr['name'] =  $userDetails['first_name']." ".$userDetails['middle_name']." ".$userDetails['last_name'];
            $user_table_arr['email'] =  $userDetails['email'];
            $user_table_arr['country_phone_code'] =  $userDetails['country_code'];
            $user_table_arr['mobile'] =  $userDetails['mobile'];
            $user_table_arr['password'] =bcrypt($user_table_arr['aahoa_id']);
            $user_table_arr['is_parent'] = '0';
            $user_table_arr['parent_id'] = $parent_id;
            $user_table_arr['email_verified_at'] =  date('Y-m-d H:i:s');
            $user_table_arr['mobile_verified_at'] =   date('Y-m-d H:i:s');
            $user_table_arr['is_super_admin'] =  '0';
            $user_table_arr['status'] = '1';
            $user_table_arr['is_admin_approved'] =  '1';
            $user_table_arr['created_by']=$created_by;

            

            // creating User in tbl_user_master
            $user = User::create($user_table_arr);
            $default_last_aahoa_id = Config::get('app.default_last_aahoa_id');
            $destination_path ='';
            $user_details_arr['user_id'] = $user->id;
            $user_details_arr['title'] =   $userDetails['title']??0;
            $user_details_arr['first_name'] =   $userDetails['first_name'];
            $user_details_arr['middle_name'] =  $userDetails['middle_name'];
            $user_details_arr['last_name'] =   $userDetails['last_name'];; 
            $user_details_arr['gender'] =   $userDetails['gender'];
            $user_details_arr['address1'] =  $userDetails['address1'];
            $user_details_arr['address2'] =   $userDetails['address2'];
   
            $user_details_arr['zipcode_id'] =   $userDetails['zip_code'];
            // $user_details_arr['date_of_birth'] =  date('Y-m-d',strtotime($userDetails['birth_date']));
            $birthDateRaw = $userDetails['birth_date'] ?? null;

            if ($birthDateRaw) 
            {
                $birthDateParsed = DateTime::createFromFormat('d/m/Y', $birthDateRaw);
                if ($birthDateParsed && $birthDateParsed->format('d/m/Y') === $birthDateRaw) {
                    $user_details_arr['date_of_birth'] = $birthDateParsed->format('Y-m-d');
                } else {
                    throw new \Exception("Invalid birth date format. Expecting dd/mm/yyyy, got: $birthDateRaw");
                }
            }
            $user_details_arr['profile_pic'] =  $destination_path; 
            $user_details_arr['relation'] = $userDetails['relation'];
            // $user_details_arr['company'] =   $userDetails['company_name'];
            // $user_details_arr['company_country_code'] =   $userDetails['company_country_code'];
            // $user_details_arr['company_phone'] =   $userDetails['company_phone'];
            $user_details_arr['status'] =  '1'; 
        
            // $user_details_arr['anniversary_date'] =  date('Y-m-d',strtotime($userDetails['anniversary_date']));
            $user_details_arr['created_by'] = $created_by;
            $user_details_arr['created_at'] =   date('Y-m-d H:i:s');
            if($relation=='Spouse'){
                $user_details_arr['is_married'] =   '1';
                
                //set parent is also married 
                $parentDetailObj =UserDetailsModel::where('user_id',$parent_id)->first();
                if(!empty($parentDetailObj) && empty($parentDetailObj->is_married)){
                    $parentDetailObj->is_married='1';
                    $parentDetailObj->save();
                }
            }
            $relation_id = $userDetails['relation'] ?? null;
            $native_district_id = $userDetails['native_district'] ?? null;
            $native_place_id = $userDetails['native_place'] ?? null;
            $occupation = $userDetails['occupation'] ?? null;
            $blood_group = !empty(trim($userDetails['blood_group'] ?? '')) 
            ? trim($userDetails['blood_group']) 
            : null;
        
            $education_level = $userDetails['education_levels'] ?? null;
  
            $marital_status = $userDetails['marital_status'] ?? null;
            $association_ids = $userDetails['association_ids'] ?? null;

            // Convert association_ids array to JSON if it's an array
            if (is_array($association_ids)) {
                $association_ids = json_encode($association_ids);
            }

            $user_details_arr['relation_id'] = $relation_id;
            $user_details_arr['occupation'] = $occupation;
            $user_details_arr['native_district_id'] = $native_district_id;
            $user_details_arr['native_place_id'] = $native_place_id;
            $user_details_arr['blood_group'] = $blood_group;
            $user_details_arr['education_level_id'] = $education_level;
            $user_details_arr['marital_status'] = $marital_status;
            $user_details_arr['association_ids'] = $association_ids;
            $user_details_arr['is_approved'] = $userDetails['is_approved'] ?? '0';
            $user_details_arr['last_degree'] = $userDetails['last_degree'];
            
            // Add business fields (non-mandatory)
            $user_details_arr['business_category_id'] = $userDetails['business_category_id'] ?? null;
            $user_details_arr['business_type_id'] = $userDetails['business_type_id'] ?? null;
            $user_details_arr['business_name'] = $userDetails['business_name'] ?? null;
            $user_details_arr['office_address'] = $userDetails['office_address'] ?? null;
            $user_details_arr['office_area_id'] = $userDetails['office_area_id'] ?? null;
            $user_details_arr['office_pincode'] = $userDetails['office_pincode'] ?? null;
            
            // Add professional fields (non-mandatory)
            $user_details_arr['professional_category'] = $userDetails['professional_category'] ?? null;
            $user_details_arr['professional_current_company'] = $userDetails['professional_current_company'] ?? null;
            
            // Handle professional office fields (reuse office address fields for professional)
            if (!empty($userDetails['prof_office_address'])) {
                $user_details_arr['office_address'] = $userDetails['prof_office_address'];
            }
            if (!empty($userDetails['prof_office_area_id'])) {
                $user_details_arr['office_area_id'] = $userDetails['prof_office_area_id'];
            }
            if (!empty($userDetails['prof_office_pincode'])) {
                $user_details_arr['office_pincode'] = $userDetails['prof_office_pincode'];
            }
            
            // Add job fields (non-mandatory)
            $user_details_arr['job_current_designation'] = $userDetails['job_current_designation'] ?? null;
            
            // Handle job fields (reuse existing fields for job)
            if (!empty($userDetails['job_current_company'])) {
                $user_details_arr['professional_current_company'] = $userDetails['job_current_company'];
            }
            if (!empty($userDetails['job_office_address'])) {
                $user_details_arr['office_address'] = $userDetails['job_office_address'];
            }
            if (!empty($userDetails['job_office_area_id'])) {
                $user_details_arr['office_area_id'] = $userDetails['job_office_area_id'];
            }
            if (!empty($userDetails['job_office_pincode'])) {
                $user_details_arr['office_pincode'] = $userDetails['job_office_pincode'];
            }
            
            // Add marital status conditional fields (non-mandatory)
            $user_details_arr['share_data_divorce'] = $userDetails['share_data_divorce'] ?? 0;
            $user_details_arr['share_data_widow'] = $userDetails['share_data_widow'] ?? 0;
            // $user_details_arr['marriage_anniversary_date'] = !empty($userDetails['marriage_anniversary_date']) ? date('Y-m-d', strtotime($userDetails['marriage_anniversary_date'])) : null;
            $marriageDateRaw = $userDetails['marriage_anniversary_date'] ?? null;

            if ($marriageDateRaw) 
            {
                $marriageDateParsed = DateTime::createFromFormat('d/m/Y', $marriageDateRaw);
                if ($marriageDateParsed && $marriageDateParsed->format('d/m/Y') === $marriageDateRaw) {
                    $user_details_arr['marriage_anniversary_date'] = $marriageDateParsed->format('Y-m-d');
                }
            }
            // Add unmarried fields (non-mandatory)
            $user_details_arr['share_data'] = $userDetails['share_data'] ?? 0;
            $user_details_arr['sankhe_1'] = $userDetails['sankhe_1'] ?? null;
            $user_details_arr['sankhe_2'] = $userDetails['sankhe_2'] ?? null;
            $user_details_arr['sankhe_3'] = $userDetails['sankhe_3'] ?? null;
            $user_details_arr['sankhe_4'] = $userDetails['sankhe_4'] ?? null;
            $user_details_arr['birth_time'] = $userDetails['birth_time'] ?? null;
            $user_details_arr['height_feet'] = $userDetails['height_feet'] ?? null;
            $user_details_arr['height_inches'] = $userDetails['height_inches'] ?? null;
            
            // Clear irrelevant marital status fields based on current selection
            if (isset($userDetails['marital_status'])) {
                $marital_status_text = '';
                $marital_statuses = config('dropdowns.marital_statuses');
                if (isset($marital_statuses[$userDetails['marital_status']])) {
                    $marital_status_text = strtolower($marital_statuses[$userDetails['marital_status']]);
                }
                
                // NOTE: Unmarried fields are now properly handled in the else clause below
                // to prevent them from being overwritten by the clearing logic
                
                // Clear fields that don't match current marital status
                if (!str_contains($marital_status_text, 'divorce')) {
                    $user_details_arr['share_data_divorce'] = 0;
                }
                if (!str_contains($marital_status_text, 'widow')) {
                    $user_details_arr['share_data_widow'] = 0;
                }
                if (!str_contains($marital_status_text, 'married') || str_contains($marital_status_text, 'unmarried')) {
                    $user_details_arr['marriage_anniversary_date'] = null;
                }
                if (!str_contains($marital_status_text, 'unmarried') && !str_contains($marital_status_text, 'single')) {
                    $user_details_arr['share_data'] = 0;
                    $user_details_arr['sankhe_1'] = null;
                    $user_details_arr['sankhe_2'] = null;
                    $user_details_arr['sankhe_3'] = null;
                    $user_details_arr['sankhe_4'] = null;
                    $user_details_arr['birth_time'] = null;
                    $user_details_arr['height_feet'] = null;
                    $user_details_arr['height_inches'] = null;
                } else {
                    // Set unmarried fields when marital status is unmarried/single
                    $user_details_arr['share_data'] = $userDetails['share_data'] ?? 0;
                    $user_details_arr['sankhe_1'] = $userDetails['sankhe_1'] ?? null;
                    $user_details_arr['sankhe_2'] = $userDetails['sankhe_2'] ?? null;
                    $user_details_arr['sankhe_3'] = $userDetails['sankhe_3'] ?? null;
                    $user_details_arr['sankhe_4'] = $userDetails['sankhe_4'] ?? null;
                    $user_details_arr['birth_time'] = $userDetails['birth_time'] ?? null;
                    $user_details_arr['height_feet'] = $userDetails['height_feet'] ?? null;
                    $user_details_arr['height_inches'] = $userDetails['height_inches'] ?? null;
                }
            }
            
            // creating User in tbl_user_details
            
            $user_details = UserDetailsModel::create($user_details_arr);


            // Assign selected region 
            if(isset($userDetails['region'])){
                
                if(!empty($userDetails['region'])){

                    $user_region_arr['user_id'] = $user->id;
                    $user_region_arr['region_id'] = $userDetails['region'];
                    $user_region_arr['status'] = '1';
    
                    $user_regions = UserRegionMapping::create($user_region_arr);

                }
            }
            
            if($user_details)
            {
                // dd(1);
                $this->assign_default_role($user->id,0);
                $this->set_all_preferences($user->id);
            }
        //    $subscription_assigned= $this->assignSubscription( $user->id,$userDetails['relation'],$parent_id,$userDetails['birth_date']);
         
        //    $subscription_assigned= $this->assignSubscriptionAsPerPrimaryMember( $user->id,$userDetails['relation'],$parent_id,$userDetails['birth_date']);
        //    if($subscription_assigned==0){
        //         DB::rollback();
        //        // Log::error($e->message());
        //         $arr_resp['status'] = 'error';
        //         $arr_resp['message'] = "error";// trans('familymember.somethingwentwrong');// $e->message();
        //         return response()->json($arr_resp, 400);
        //     }

            // sending registration email;
            
            if($userDetails['email']==''){
                $parent = User::where('id',$parent_id)->first();
                $userDetails['email'] = $parent->email;
            }

            // $email_parameter['view'] = 'web.registration.template_registration_success_email';
            // $email_parameter['data']= array('name'=>$userDetails['first_name']);
            // $email_parameter['toemails'] = $userDetails['email'];
            // $email_parameter['subject']="Registration Successful";
            $profile = User::where('id',$user->id)->with(['details','details.nameTitle','details.country','details.getRegion','details.state','details.city','details.zipcode'])->first();
            // sending registration email;
            $aahoa_id = $profile->aahoa_id;
            $email_parameter['view'] = 'web.registration.template_registration_success_email_copy';
            $email_parameter['data']= array('profile'=>$profile, 'aahoa_id' => $aahoa_id);
            if($profile->email)
            {
                $email_parameter['toemails'] = $profile->email;

            }
            else
            {
            //     dd($parent_Details->first()->email);
            //     // dd($parent_Details->email);
                $email_parameter['toemails'] = $parent_Details->first()->email;
            }
            $email_parameter['subject']="(".$aahoa_id.") Registration successful $profile->name ";
            
            $this->EmailServices->send_email($email_parameter);
            // sending registration email end 
            

           // DB::commit();
            
            //upload profile image
            $temp_uploaded_path = $userDetails['image_path'];

            if($temp_uploaded_path !=""){
                $file_path_arr = explode('/',$temp_uploaded_path);
                $destination_path = date('Y/m/d')."/profile_images/".$file_path_arr[count($file_path_arr)-1];
                Storage::move($temp_uploaded_path, $destination_path);
            } else {
                $destination_path = '';
            }
            $update_image = UserDetailsModel::find($user_details->id);
            $update_image->profile_pic = $destination_path;
            $update_image->save();

            //upload business image
            $business_temp_uploaded_path = $userDetails['business_image_path'] ?? '';

            if($business_temp_uploaded_path !=""){
                $business_file_path_arr = explode('/',$business_temp_uploaded_path);
                $business_destination_path = date('Y/m/d')."/business_images/".$business_file_path_arr[count($business_file_path_arr)-1];
                Storage::move($business_temp_uploaded_path, $business_destination_path);
            } else {
                $business_destination_path = '';
            }
            
            // Update business image in user details
            if($business_destination_path != '') {
                $update_business_image = UserDetailsModel::find($user_details->id);
                $update_business_image->business_image = $business_destination_path;
                $update_business_image->save();
            }

            //upload professional image
            $professional_temp_uploaded_path = $userDetails['professional_image_path'] ?? '';

            if($professional_temp_uploaded_path !=""){
                $professional_file_path_arr = explode('/',$professional_temp_uploaded_path);
                $professional_destination_path = date('Y/m/d')."/professional_images/".$professional_file_path_arr[count($professional_file_path_arr)-1];
                Storage::move($professional_temp_uploaded_path, $professional_destination_path);
            } else {
                $professional_destination_path = '';
            }
            
            // Update professional image in user details
            if($professional_destination_path != '') {
                $update_professional_image = UserDetailsModel::find($user_details->id);
                $update_professional_image->professional_image = $professional_destination_path;
                $update_professional_image->save();
            }

            DB::commit();

            $this->add_activityLog($parent_id,$created_by,$parent_id,'add',$guard,' App\Models\User',$request,$relation);
           // $redirecturl = route('family.list');
           //$redirecturl = (''!=$request->input('return_url')) ? $request->input('return_url') : route('family.list'); 
           $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('familymember.family_member_added_successfully');
            //$arr_resp['redirecturl'] =  $redirecturl;
            return response()->json($arr_resp, 200);
      }catch(Exception $e){
        DB::rollback();
        
                Log::error($e->message());
                $arr_resp['status'] = 'error';
                $arr_resp['message'] =  $e->message(); //trans('familymember.somethingwentwrong');//
                return response()->json($arr_resp, 400);
      }
    }
    

}
