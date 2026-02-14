@extends('layouts.app')

@section('title', 'Edit Location')

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
            <li class="breadcrumb-item active">Edit Location</li>
        </ol>
    </nav>

    <form id="location_edit_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Edit Location</h4>

        <div class="row g-3">

            <!-- Location Name -->
            <div class="col-12">
                <label class="form-label required">Location Name</label>
                <input type="text"
                       class="form-control"
                       name="location_name"
                       value="{{ old('location_name', $location->location_name) }}">
                <div class="text-danger error-message" data-error-for="location_name"></div>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label class="form-label required">Status</label>
                <select class="form-control" name="is_active">
                    <option value="1" {{ $location->is_active == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $location->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                <div class="text-danger error-message" data-error-for="is_active"></div>
            </div>

        </div>

        <!-- Buttons -->
        <div class="text-end mt-4">
            <a href="{{ route('list_locations') }}"
               class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>

            <button type="submit"
                    class="btn"
                    id="submitLocationBtn">
                Update
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const submitLocationUpdateUrl = "{{ route('update_location', $location->id) }}";
</script>

<script src="{{ asset('assets/js/location/edit_location.js') }}"></script>
@endpush
