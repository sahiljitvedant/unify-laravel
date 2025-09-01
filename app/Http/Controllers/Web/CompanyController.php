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

class CompanyController extends Controller
{
    public function list()
    {
        return view('company.list_company');
    }
    public function fetch_comapny_list (Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_companies')
            ->select('*')
            ->where('is_deleted', '=', 0);

        // Apply filters
        if ($request->filled('company_name')) {
            $query->where('company_name', $request->company_name);
        }

        // if ($request->filled('trainer')) {
        //     // Convert 1 => 'yes', 0 => 'no'
        //     $trainerValue = $request->trainer == 1 ? 'yes' : 'no';
        //     $query->where('trainer_included', $trainerValue);
        // }

        if ($request->filled('mobile')) {
            $query->where('mobile', '>=', $request->mobile);
        }

        if ($request->filled('email')) {
            $query->where('email', '<=', $request->email);
        }

        // Sorting
        $allowedSorts = [
            'id',
            'company_name',
            'email',
            'mobile',
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
                <a href="'.route('edit_company', $encryptedId).'" class="btn btn-sm" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-sm" onclick="deleteMembershipById('.$row->id.')">
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

        return view('company.add_company', compact('memberships','trainer'));
       
    }
    public function create_company(Request $request)
    {
        // dd($request->all());
        $arr_rules = 
        [
            'company_name'           => 'required|string|max:255',
            'company_mailing_name'   => 'required|string|max:255',
            'address'                => 'nullable|string|max:500',
            'country'                => 'required|string|max:100',
            'state'                  => 'nullable',
            'pincode'                => 'nullable',
            'phone'                  => 'nullable',
            'mobile'                 => 'nullable',
            'fax_no'                 => 'nullable',
            'email'                  => 'nullable',
            'website'                => 'nullable',
        
            'financial_year'         => 'required|date',
            'books_begin'            => 'required|date',
        
            'password'               => 'nullable|string|min:6',
            'confirm_password'       => 'same:password',
        
            'use_security'           => 'required|in:yes,no',
            'security_password'      => 'nullable|string|min:6|required_if:use_security,yes',
            'confirm_security_password' => 'same:security_password|required_if:use_security,yes',
        
            'suffix_symbol'          => 'required|in:yes,no',
            'space_between'          => 'required|in:yes,no',
            'show_in_millions'       => 'required|in:yes,no',
            'decimal_places'         => 'required|integer|min:0|max:6',
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
    
            $inserted_id = DB::table('tbl_companies')->insertGetId($user_details_arr);
            // Create user for login
            // $full_name = $request->first_name . ' ' . $request->last_name;

           
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
        // dd(1);
        try 
        {
            // dd($id);

            $dec = Crypt::decryptString($id);

            // dd($dec);
            $member = DB::table('tbl_companies')->where('id', $dec)->first();
    
            if (!$member) 
            {
                dd("Page not found");
                return redirect()->back()->with('error', 'Member not found!');
            }
    
            return view('company.tabs.index', compact('member'));
        } 
        catch (\Exception $e)
        {
            // dd($e->getMessage());
            Log::error('Edit member failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching the member.');
        }
    }

    public function update_company_profile (Request $request,$id)
    {
        // dd(1);
        // dd($request->all());
        // Validation rules
        $arr_rules = 
        [
            // New fields
            'financial_year'            => 'required|date',
            'books_begin'               => 'required|date|after_or_equal:financial_year',
            'password'                  => 'nullable|string|min:6',
            'confirm_password'          => 'nullable|string|same:password',
            'use_security'              => 'required|in:yes,no',
            'security_password'         => 'nullable|required_if:use_security,yes|string|min:6',
            'confirm_security_password' => 'nullable|required_with:security_password|same:security_password',
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
    
            // Update existing record by ID
            $updated = DB::table('tbl_companies')
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

    public function update_home_profile (Request $request,$id)
    {
        dd(1);
        // dd($request->all());
        // Validation rules
        $arr_rules = 
        [
            // New fields
            'financial_year'            => 'required|date',
            'books_begin'               => 'required|date|after_or_equal:financial_year',
            'password'                  => 'nullable|string|min:6',
            'confirm_password'          => 'nullable|string|same:password',
            'use_security'              => 'required|in:yes,no',
            'security_password'         => 'nullable|required_if:use_security,yes|string|min:6',
            'confirm_security_password' => 'nullable|required_with:security_password|same:security_password',
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
    
            // Update existing record by ID
            $updated = DB::table('tbl_companies')
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
  
    public function delete_comapny($id)
    {
        // dd(1);
        $membership = DB::table('tbl_companies')->where('id', $id)->first();
        // dd($membership);
        if (!$membership) 
        {
            return response()->json(['status' => false, 'message' => 'Membership not found'], 404);
        }

        DB::table('tbl_companies')
        ->where('id', $id)
        ->update([
            'is_deleted' => 9,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Company deleted successfully'
        ]);
    }

}
