<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;

class CustomerController extends Controller
{
    /* =======================
     * LIST PAGE
     * ======================= */
    public function list()
    {
        return view('customer.list_customer');
    }

    /* =======================
     * FETCH CUSTOMERS
     * ======================= */
    public function fetch_customers(Request $request)
    {
        $query = DB::table('customers')
            ->where('is_deleted', '!=', 9);

        // Filters
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }

        // Sorting
        $allowedSorts = ['id', 'customer_name'];
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'asc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            $order = 'asc';
        }

        $query->orderBy($sort, $order);

        $customers = $query->paginate(10);

        $customers->getCollection()->transform(function ($row) {
            $row->action = '
                <a href="' . route('edit_customer', $row->id) . '" class="btn btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button class="btn btn-sm" onclick="deleteCustomer(' . $row->id . ')">
                    <i class="bi bi-trash"></i>
                </button>';
            return $row;
        });

        return response()->json($customers);
    }

    /* =======================
     * ADD PAGE
     * ======================= */
    public function add()
    {
        return view('customer.add_customer');
    }

    /* =======================
     * STORE CUSTOMER
     * ======================= */
    public function store(Request $request)
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
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
            Customer::create([
                'customer_name' => $request->customer_name,
                'is_active'     => $request->is_active,
                'is_deleted'    => 0,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Customer added successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Customer Store Error: ' . $e->getMessage());

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
        $customer = Customer::find($id);

        if (!$customer) {
            abort(404, 'Customer not found');
        }

        return view('customer.edit_customer', compact('customer'));
    }

    /* =======================
     * UPDATE CUSTOMER
     * ======================= */
    public function update(Request $request, $id)
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
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
            Customer::where('id', $id)->update([
                'customer_name' => $request->customer_name,
                'is_active'     => $request->is_active,
                'updated_at'    => now(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Customer updated successfully'
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
     * DELETE CUSTOMER
     * ======================= */
    public function delete($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'status'  => false,
                'message' => 'Customer not found'
            ], 404);
        }

        $customer->is_deleted = 9;
        $customer->save();

        return response()->json([
            'status'  => true,
            'message' => 'Customer deleted successfully'
        ]);
    }

    /* =======================
     * ACTIVATE CUSTOMER
     * ======================= */
    public function activate($id)
    {
        $customer = Customer::where('id', $id)
            ->where('is_deleted', 9)
            ->first();

        if (!$customer) {
            return response()->json([
                'status'  => false,
                'message' => 'Customer not found'
            ], 404);
        }

        $customer->is_deleted = 0;
        $customer->save();

        return response()->json([
            'status'  => true,
            'message' => 'Customer activated successfully'
        ]);
    }

    /* =======================
     * LIST DELETED CUSTOMERS
     * ======================= */
    public function list_deleted_customers()
    {
        return view('customer.list_deleted_customer');
    }

    /* =======================
     * FETCH DELETED CUSTOMERS
     * ======================= */
    public function fetch_deleted_customers(Request $request)
    {
        $query = DB::table('customers')
            ->where('is_deleted', '=', 9);

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }

        $query->orderBy('id', 'desc');

        $customers = $query->paginate(10);

        $customers->getCollection()->transform(function ($row) {
            $row->action = '
                <button type="button" class="btn btn-sm"
                    onclick="activateCustomerById('.$row->id.')">
                    <i class="bi bi-check-circle"></i>
                </button>';
            return $row;
        });

        return response()->json($customers);
    }
}
