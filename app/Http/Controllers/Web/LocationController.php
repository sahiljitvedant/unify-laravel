<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Location;

class LocationController extends Controller
{
    /* =======================
     * LIST PAGE
     * ======================= */
    public function list()
    {
        return view('location.list_location');
    }

    /* =======================
     * FETCH LOCATIONS
     * ======================= */
    public function fetch_locations(Request $request)
    {
        $query = DB::table('locations')
            ->where('is_deleted', '!=', 9);

        // Filters
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('location_name')) {
            $query->where('location_name', 'like', '%' . $request->location_name . '%');
        }

        // Sorting
        $allowedSorts = ['id', 'location_name'];
        $sort  = $request->get('sort', 'id');
        $order = $request->get('order', 'asc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $query->orderBy($sort, $order);

        $locations = $query->paginate(10);

        $locations->getCollection()->transform(function ($row) {
            $row->action = '
                <a href="' . route('edit_location', $row->id) . '" class="btn btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button class="btn btn-sm" onclick="deleteLocation(' . $row->id . ')">
                    <i class="bi bi-trash"></i>
                </button>';
            return $row;
        });

        return response()->json($locations);
    }

    /* =======================
     * ADD PAGE
     * ======================= */
    public function add()
    {
        return view('location.add_location');
    }

    /* =======================
     * STORE LOCATION
     * ======================= */
    public function store(Request $request)
    {
        $rules = [
            'location_name' => 'required|string|max:255',
            'is_active'     => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        try {
            Location::create([
                'location_name' => $request->location_name,
                'is_active'     => $request->is_active,
                'is_deleted'    => 0,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Location added successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Location Store Error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /* =======================
     * EDIT PAGE
     * ======================= */
    public function edit($id)
    {
        $location = Location::find($id);

        if (!$location) {
            abort(404, 'Location not found');
        }

        return view('location.edit_location', compact('location'));
    }

    /* =======================
     * UPDATE LOCATION
     * ======================= */
    public function update(Request $request, $id)
    {
        $rules = [
            'location_name' => 'required|string|max:255',
            'is_active'     => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->messages()
            ], 422);
        }

        try {
            Location::where('id', $id)->update([
                'location_name' => $request->location_name,
                'is_active'     => $request->is_active,
                'updated_at'    => now(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Location updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /* =======================
     * DELETE LOCATION
     * ======================= */
    public function delete($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'status'  => false,
                'message' => 'Location not found'
            ], 404);
        }

        $location->is_deleted = 9;
        $location->save();

        return response()->json([
            'status'  => true,
            'message' => 'Location deleted successfully'
        ]);
    }

    /* =======================
     * ACTIVATE LOCATION
     * ======================= */
    public function activate($id)
    {
        $location = Location::where('id', $id)
            ->where('is_deleted', 9)
            ->first();

        if (!$location) {
            return response()->json([
                'status'  => false,
                'message' => 'Location not found'
            ], 404);
        }

        $location->is_deleted = 0;
        $location->save();

        return response()->json([
            'status'  => true,
            'message' => 'Location activated successfully'
        ]);
    }

    /* =======================
     * LIST DELETED LOCATIONS
     * ======================= */
    public function list_deleted_locations()
    {
        return view('location.list_deleted_location');
    }

    /* =======================
     * FETCH DELETED LOCATIONS
     * ======================= */
    public function fetch_deleted_locations(Request $request)
    {
        $query = DB::table('locations')
            ->where('is_deleted', 9);

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('location_name')) {
            $query->where('location_name', 'like', '%' . $request->location_name . '%');
        }

        $query->orderBy('id', 'desc');

        $locations = $query->paginate(10);

        $locations->getCollection()->transform(function ($row) {
            $row->action = '
                <button type="button" class="btn btn-sm"
                    onclick="activateLocationById('.$row->id.')">
                    <i class="bi bi-check-circle"></i>
                </button>';
            return $row;
        });

        return response()->json($locations);
    }
}
