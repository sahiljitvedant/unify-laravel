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

class PolicyController extends Controller
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

        // if ($request->filled('trainer')) {
        //     // Convert 1 => 'yes', 0 => 'no'
        //     $trainerValue = $request->trainer == 1 ? 'yes' : 'no';
        //     $query->where('trainer_included', $trainerValue);
        // }

        if ($request->filled('trainerName')) {
            $query->where('trainer_name', '=', $request->trainerName);
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
        // // dd(1);
        // $request->validate([
        //     'policy_description' => 'required|string|max:5000',
        // ]);
        $policy_description = DB::table('tbl_policy')->value('description');
    
        return view('Policy.add_policy', compact('policy_description'));
    }
    

    public function submit(Request $request)
    {
        // Only get the description
        $policy_data = $request->only(['policy_description']);

        // Validation (remove 'string')
        $validator = Validator::make($policy_data, [
            'policy_description' => 'required|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Check if any policy exists
            $existingPolicy = DB::table('tbl_policy')->first();

            if ($existingPolicy) {
                // Update the existing record
                DB::table('tbl_policy')
                    ->where('id', $existingPolicy->id)
                    ->update([
                        'description' => $policy_data['policy_description'] // will save HTML
                    ]);

                $message = 'Policy updated successfully';
                $policy_id = $existingPolicy->id;
            } else {
                // Insert new record
                $policy_id = DB::table('tbl_policy')->insertGetId([
                    'description' => $policy_data['policy_description']
                ]);

                $message = 'Policy added successfully';
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'policy_id' => $policy_id
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

    
    public function privacy_policy()
    {
        
        $policy  = DB::table('tbl_policy')->first();
        // dd($policy);
        if (!$policy ) {
            abort(404, 'Policy not found');
        }

        // Pass existing member data into the form
        return view('front.privacy_policy', compact('policy'));
        
    }
   
}
