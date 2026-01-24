<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Membership;
class GymMembershipApiController extends Controller
{
    // public function index()
    // {
    //     $memberships = DB::table('tbl_gym_membership')
    //         ->where('is_deleted', '0')
    //         ->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $memberships
    //     ]);
    // }
    public function index() 
    {

        $memberships = Membership::select('membership_name', 'duration_in_days')->get();
        return response()->json
        ([
            'status' => true,
            'data' => $memberships
        ]);
    }
    

    public function show($id)
    {
        $membership = DB::table('tbl_gym_membership')
            ->where('id', $id)
            ->where('is_deleted','0')
            ->first();

        if (!$membership) {
            return response()->json(['status' => 'error', 'message' => 'Membership not found'], 404);
        }

        return response()->jso
        ([
            'status' => 'success', 
            'data' => $membership
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $rules =
        [
            'membership_name' => 'required|string|max:150|unique:tbl_gym_membership,membership_name',
            'description' => 'nullable|string|max:500',
            'duration_in_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'trainer_included' => 'required|in:0,1',
            'facilities_included' => 'nullable|array',
            'facilities_included.*' => 'integer',
            'is_active' => 'required|in:0,1',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->messages()], 422);
        }

        DB::beginTransaction();
        try 
        {
            if (isset($input['facilities_included'])) {
                $input['facilities_included'] = json_encode($input['facilities_included']);
            }
            $input['is_deleted'] = '0';

            $inserted_id = DB::table('tbl_gym_membership')->insertGetId($input);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Membership added successfully',
                'id' => $inserted_id
            ], 201);

        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $membership = DB::table('tbl_gym_membership')->where('id', $id)->first();

        if (!$membership) {
            return response()->json(['status' => 'error', 'message' => 'Membership not found'], 404);
        }

        $input = $request->all();

        $rules = [
            'membership_name' => 'sometimes|string|max:150|unique:tbl_gym_membership,membership_name,' . $id,
            'description' => 'nullable|string|max:500',
            'duration_in_days' => 'sometimes|integer|min:1',
            'price' => 'sometimes|numeric|min:0',
            'trainer_included' => 'sometimes|in:0,1',
            'facilities_included' => 'nullable|array',
            'facilities_included.*' => 'integer',
            'is_active' => 'sometimes|in:0,1',
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->messages()], 422);
        }

        if (isset($input['facilities_included'])) {
            $input['facilities_included'] = json_encode($input['facilities_included']);
        }

        DB::table('tbl_gym_membership')->where('id', $id)->update($input);

        return response()->json(['status' => 'success', 'message' => 'Membership updated successfully']);
    }

    public function destroy($id)
    {
        $membership = DB::table('tbl_gym_membership')->where('id', $id)->first();

        if (!$membership) {
            return response()->json(['status' => 'error', 'message' => 'Membership not found'], 404);
        }

        DB::table('tbl_gym_membership')->where('id', $id)->update(['is_deleted' => 1]);

        return response()->json(['status' => 'success', 'message' => 'Membership deleted successfully']);
    }
}
