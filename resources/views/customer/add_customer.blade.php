@extends('layouts.app')

@section('title', 'Add Customer')

@section('content')
<div class="container-custom">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('list_dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('list_customers') }}">Customers</a>
            </li>
            <li class="breadcrumb-item active">Add Customer</li>
        </ol>
    </nav>

    <form id="customer_add_form" class="p-4 bg-light rounded shadow">

        <h4 class="mb-4">Add Customer</h4>

        <div class="row g-3">

            <div class="col-12">
                <label class="form-label required">Customer Name</label>
                <input type="text" class="form-control" name="customer_name" id="customer_name">
                <div class="text-danger error-message" data-error-for="customer_name"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label required">Status</label>
                <select class="form-control" name="is_active" id="is_active">
                    <option disabled selected>Select status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <div class="text-danger error-message" data-error-for="is_active"></div>
            </div>

        </div>

        <div class="text-end mt-4">
            <a href="{{ route('list_customers') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitCustomerBtn">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const submitCustomerUrl = "{{ route('store_customer') }}";
</script>
<script src="{{ asset('assets/js/customer/add_customer.js') }}"></script>
@endpush
