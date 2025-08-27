<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables; 

class GymMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        return view('gym_membership.list_membership');
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add()
    {
        // dd(1);
        return view('gym_membership.add_form');
    }

    public function fetchMembership(Request $request)
    {
        // dd(1);
        // ONE variable that fetches everything you need
        $fetch_data = DB::table('tbl_gym_membership')
            ->select('*')
            ->orderBy('id', 'desc')
            ->get();

        // Send to DataTables (server-side)
        return DataTables::of($fetch_data)
            ->addColumn('action', function ($row) {
                return ' <a href="/members/edit/'.$row->id.'" class="btn btn-sm" data-bs-toggle="tooltip" title="Edit">
                <i class="bi bi-pencil-square"></i>
            </a>
            <a href="/members/delete/'.$row->id.'" class="btn btn-sm" data-bs-toggle="tooltip" title="Delete">
                <i class="bi bi-trash"></i>
            </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function submit(Request $request)
    {
        // dd($request->all());
        // Validation rules
        $arr_rules = [
            'membership_name' => 'required|string|max:150',
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

       /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
