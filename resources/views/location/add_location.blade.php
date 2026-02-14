@extends('layouts.app')

@section('title', 'Add Location')

@section('content')
<div class="container-custom">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('list_dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('list_locations') }}">Locations</a>
            </li>
            <li class="breadcrumb-item active">Add Location</li>
        </ol>
    </nav>

    <form id="location_add_form" class="p-4 bg-light rounded shadow">

        <h4 class="mb-4">Add Location</h4>

        <div class="row g-3">

            <div class="col-12">
                <label class="form-label required">Location Name</label>
                <input type="text"
                       class="form-control"
                       name="location_name"
                       id="location_name">
                <div class="text-danger error-message" data-error-for="location_name"></div>
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
            <a href="{{ route('list_locations') }}"
               class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitLocationBtn">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const submitLocationUrl = "{{ route('store_location') }}";
</script>
<script src="{{ asset('assets/js/location/add_location.js') }}"></script>
@endpush
