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
use Illuminate\Validation\Rule;
class TrainerController extends Controller
{
    public function list()
    {
        return view('trainer.list_trainer');
       
    }

    public function fetch_trainer_list(Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_trainer')
            ->select('*')
            ->where('is_deleted', '!=', 9);

        // Apply filters
        if ($request->filled('active')) {
            $query->where('is_active', $request->active);
        }

    
        if ($request->filled('trainerName')) {
            $query->where('trainer_name', 'LIKE', '%' . $request->trainerName . '%');
        }

        if ($request->filled('joiningDate')) {
            $query->where('joining_date', '=', $request->joiningDate);
        }
        if ($request->filled('mobileNumber')) {
            $query->where('mobile_number', 'LIKE', '%' . $request->mobileNumber . '%');
        }
        

        // Sorting
        $allowedSorts = [
            'id',
            'trainer_name',
            'joining_date',
            'expiry_date',
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
        $trainer = $query->paginate(10);

        // Add action + encrypted_id
        $trainer->getCollection()->transform(function ($row) {
            $encryptedId = Crypt::encryptString($row->id);
            $row->encrypted_id = $encryptedId;
            $row->action = '
                <a href="'.route('edit_trainer', $encryptedId).'" class="btn btn-sm" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-sm" onclick="deleteMembershipById('.$row->id.')">
                    <i class="bi bi-trash"></i>
                </button>';
            return $row;
        });

        return response()->json($trainer);
    }
    public function add()
    {
        return view('trainer.add_trainer');
    }

    public function submit(Request $request)
    {
        // dd($request->all());

        // Validation rules
        $arr_rules = [
            'trainer_name' => 'required|string|max:150',
            'joining_date' => 'required|date', 
            'expiry_date' => 'nullable|date', 
            'is_active' => 'required|boolean',
            'mobile_number'=> 'required',
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
            $user_details_arr = $request->all();
            // dd( $user_details_arr);

            $inserted_id = DB::table('tbl_trainer')->insertGetId($user_details_arr);
           
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
        
        // dd($id);
        // dd('This is edit page');

        // dd($id);

        $decryptedId = Crypt::decryptString($id);
        // dd($decryptedId);
        $member = DB::table('tbl_trainer')->where('id', $decryptedId)->first();

        if (!$member) {
            abort(404, 'Member not found');
        }

        // Pass existing member data into the form
        return view('trainer.edit_trainer', compact('member'));
       
    }

  
    public function update(Request $request, $id)
    {
        try 
        {
            // ✅ Validation
            $request->validate([
                'trainer_name' => [
                    'required',
                    'string',
                    'min:3',
                    'max:50', // slightly more practical limit than 5
                    Rule::unique('tbl_trainer', 'trainer_name')->ignore($id)
                ],
                'mobile_number' => [
                    'required',
                    'digits:10',
                    Rule::unique('tbl_trainer', 'mobile_number')->ignore($id)
                ],
                'joining_date' => 'required|date',
                'is_active' => 'required',
            ]);

            // ✅ Update record
            DB::table('tbl_trainer')
                ->where('id', $id)
                ->update([
                    'trainer_name'  => $request->trainer_name,
                    'mobile_number' => $request->mobile_number,
                    'is_active'     => $request->is_active,
                    'joining_date'  => $request->joining_date,
                    'expiry_date'   => $request->expiry_date,
                ]);

            // ✅ Return success
            return response()->json([
                'success' => true, 
                'message' => 'Trainer updated successfully!'
            ]);
        } 
        catch (\Illuminate\Validation\ValidationException $e) 
        {
            // Validation errors
            return response()->json([
                'success' => false, 
                'errors'  => $e->errors()
            ], 422);
        } 
        catch (\Exception $e) 
        {
            // Unexpected errors
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    
    public function deleteTrainer($id)
    {
        // dd(1);
        $trainer = DB::table('tbl_trainer')->where('id', $id)->first();
        // dd($trainer);
        if (!$trainer) 
        {
            return response()->json(['status' => false, 'message' => 'Trainer not found'], 404);
        }

        DB::table('tbl_trainer')
        ->where('id', $id)
        ->update([
            'is_deleted' => 9,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Trainer deleted successfully'
        ]);
    }

    public function list_deleted_trainer()
    {
        return view('trainer.list_deleted_trainer');
    }

    public function fetch_deleted_trainer(Request $request)
    {
        // dd($request->all());
        $query = DB::table('tbl_trainer')
            ->select('*')
            ->where('is_deleted', '=', 9);

        // Apply filters
        if ($request->filled('active')) {
            $query->where('is_active', $request->active);
        }

        // if ($request->filled('trainer')) {
        //     // Convert 1 => 'yes', 0 => 'no'
        //     $trainerValue = $request->trainer == 1 ? 'yes' : 'no';
        //     $query->where('trainer_included', $trainerValue);
        // }

        if ($request->filled('trainerName')) {
            $query->where('trainer_name', 'LIKE', '%' . $request->trainerName . '%');
        }

        if ($request->filled('joiningDate')) {
            $query->where('joining_date', '=', $request->joiningDate);
        }

        // Sorting
        $allowedSorts = [
            'id',
            'trainer_name',
            'joining_date',
            'expiry_date',
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
        $trainer = $query->paginate(10);

        // Add action + encrypted_id
        $trainer->getCollection()->transform(function ($row) {
            $encryptedId = Crypt::encryptString($row->id);
            $row->encrypted_id = $encryptedId;
            $row->action = '
            <button type="button" class="btn btn-sm" onclick="activateTrainerID('.$row->id.')">
                <i class="bi bi-check-circle"></i>
            </button>';
            return $row;
        });

        return response()->json($trainer);
    }

    public function activate_trainer($id)
    {
        // dd(1);
        $trainer = DB::table('tbl_trainer')->where('id', $id)->first();
        // dd($trainer);
        if (!$trainer) 
        {
            return response()->json(['status' => false, 'message' => 'Trainer not found'], 404);
        }

        DB::table('tbl_trainer')
        ->where('id', $id)
        ->update([
            'is_deleted' => 1,  
        ]);
        return response()->json
        ([
            'status' => true,
            'message' => 'Trainer activated successfully'
        ]);
    }

}
