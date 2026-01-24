@extends('layouts.app')

@section('title', 'Add Career')

@section('content')
<div class="container-custom">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('list_dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('list_careers') }}">Careers</a>
            </li>
            <li class="breadcrumb-item active">Add Career</li>
        </ol>
    </nav>

    <form id="career_add_form" class="p-4 bg-light rounded shadow">

        <h4 class="mb-4">Add Career</h4>

        <div class="row g-3">

            <!-- Designation -->
            <div class="col-12">
                <label class="form-label required">Designation</label>
                <input type="text" class="form-control" name="designation">
                <div class="text-danger error-message" data-error-for="designation"></div>
            </div>

            <!-- Experience Text -->
            <div class="col-md-6 col-12">
                <label class="form-label required">Experience (Text)</label>
                <input type="text" class="form-control" name="experience">
                <div class="text-danger error-message" data-error-for="experience"></div>
            </div>

            <!-- Years of Experience -->
            <div class="col-md-6 col-12">
                <label class="form-label required">Years of Experience</label>
                <input type="number" class="form-control" name="years_of_experience">
                <div class="text-danger error-message" data-error-for="years_of_experience"></div>
            </div>

            <!-- Location -->
            <div class="col-md-6 col-12">
                <label class="form-label required">Location</label>
                <input type="text" class="form-control" name="location">
                <div class="text-danger error-message" data-error-for="location"></div>
            </div>

            <!-- Work Type -->
            <div class="col-md-6 col-12">
                <label class="form-label required">Work Type</label>
                <select class="form-control" name="work_type">
                    <option disabled selected>Select work type</option>
                    <option value="wfo">Work From Office</option>
                    <option value="wfh">Work From Home</option>
                    <option value="remote">Remote</option>
                </select>
                <div class="text-danger error-message" data-error-for="work_type"></div>
            </div>

            <!-- Job Description -->
            <div class="col-12">
                <label class="form-label required">Job Description</label>
                <textarea class="form-control" name="job_description" rows="4"></textarea>
                <div class="text-danger error-message" data-error-for="job_description"></div>
            </div>

            <!-- Status -->
            <div class="col-md-6 col-12">
                <label class="form-label required">Status</label>
                <select class="form-control" name="status">
                    <option disabled selected>Select status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <div class="text-danger error-message" data-error-for="status"></div>
            </div>

        </div>

        <div class="text-end mt-4">
            <a href="{{ route('list_careers') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitBtn">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const submitCareerUrl = "{{ route('store_career') }}";
</script>
<script src="{{ asset('assets/js/career/add_career.js') }}"></script>
@endpush
