@extends('layouts.app')

@section('title', 'Edit Customer')

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
            <li class="breadcrumb-item active">Edit Customer</li>
        </ol>
    </nav>

    <form id="customer_edit_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Edit Customer</h4>

        <div class="row g-3">

            <!-- Customer Name -->
            <div class="col-12">
                <label class="form-label required">Customer Name</label>
                <input type="text"
                       class="form-control"
                       name="customer_name"
                       value="{{ old('customer_name', $customer->customer_name) }}">
                <div class="text-danger error-message" data-error-for="customer_name"></div>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label class="form-label required">Status</label>
                <select class="form-control" name="is_active">
                    <option value="1" {{ $customer->is_active == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $customer->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                <div class="text-danger error-message" data-error-for="is_active"></div>
            </div>

        </div>

        <!-- Buttons -->
        <div class="text-end mt-4">
            <a href="{{ route('list_customers') }}"
               class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>

            <button type="submit"
                    class="btn"
                    id="submitCustomerBtn">
                Update
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const submitCustomerUpdateUrl = "{{ route('update_customer', $customer->id) }}";
</script>

<script src="{{ asset('assets/js/customer/edit_customer.js') }}"></script>
@endpush
