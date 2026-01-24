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
use Carbon\Carbon;
class PolicyController extends Controller
{
    public function list()
    {
        return view('trainer.list_trainer');
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
        $now = Carbon::now(); 
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
                        'description' => $policy_data['policy_description'] ,
                        'updated_at' => $now,// will save HTML
                    ]);

                $message = 'Policy updated successfully';
                $policy_id = $existingPolicy->id;
            } else {
                // Insert new record
                $policy_id = DB::table('tbl_policy')->insertGetId([
                    'description' => $policy_data['policy_description'],
                    'created_at' => $now, // set created_at
                    'updated_at' => $now, // set updated_at
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
