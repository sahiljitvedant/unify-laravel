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

            <div class="col-12">
                <label class="form-label required">Designation</label>
                <input type="text" class="form-control" name="designation">
                <div class="text-danger error-message" data-error-for="designation"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label required">Years of Experience</label>
                <input type="number" class="form-control" name="years_of_experience">
                <div class="text-danger error-message" data-error-for="years_of_experience"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label required">Location</label>
                <input type="text" class="form-control" name="location">
                <div class="text-danger error-message" data-error-for="location"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label required">Work Type</label>
                <select class="form-control" name="work_type">
                    <option disabled selected>Select work type</option>
                    <option value="wfo">Work From Office</option>
                    <option value="wfh">Work From Home</option>
                    <option value="remote">On Field</option>
                </select>
                <div class="text-danger error-message" data-error-for="work_type"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label required">Number of Vacancies</label>
                <input type="number" class="form-control" name="vacancies">
                <div class="text-danger error-message" data-error-for="vacancies"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label required">Application Start Date</label>
                <input type="date" class="form-control" name="application_start_date">
                <div class="text-danger error-message" data-error-for="application_start_date"></div>
            </div>

            <div class="col-md-6 col-12">
                <label class="form-label required">Application End Date</label>
                <input type="date" class="form-control" name="application_end_date">
                <div class="text-danger error-message" data-error-for="application_end_date"></div>
            </div>

            <!-- ✅ CKEDITOR FIELD ADDED -->
            <div class="col-12">
                <label class="form-label required">Job Description</label>
                <textarea class="form-control" id="job_description" name="job_description" rows="4"></textarea>
                <div class="text-danger error-message" data-error-for="job_description"></div>
            </div>

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
            <a href="{{ route('list_careers') }}" class="btn btn-secondary me-2 cncl_btn">Cancel</a>
            <button type="submit" class="btn" id="submitBtn">Submit</button>
        </div>
    </form>

</div>
@endsection


@push('scripts')

<!-- CKEDITOR CDN (same as policy page) -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

<script>
    const submitCareerUrl = "{{ route('store_career') }}";
</script>

<script src="{{ asset('assets/js/career/add_career.js') }}"></script>

@endpush
