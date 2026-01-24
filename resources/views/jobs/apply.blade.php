@extends('layouts.app')

@section('title', 'Apply for Job')

@section('content')
<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Apply for Job</li>
        </ol>
    </nav>

    <form id="job_apply_form" class="p-4 bg-light rounded shadow">
        <!-- Form Heading -->
        <h4 class="mb-4">Apply for Job</h4>
        <div class="step" data-step="1">
            <div class="row g-3">
                <div class="col-md-6 col-12">
                    <label class="form-label required">Job Title</label>
                    <input type="text" class="form-control" name="job_title" id="job_title" placeholder="Enter Job Title">
                    <div class="text-danger error-message" data-error-for="job_title"></div>
                </div>

                <div class="col-md-6 col-12">
                    <label class="form-label required">Experience Needed</label>
                    <input type="text" class="form-control" name="experience_needed" id="experience_needed" placeholder="e.g. 2 Years">
                    <div class="text-danger error-message" data-error-for="experience_needed"></div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6 col-12">
                    <label class="form-label required">City</label>
                    <input type="text" class="form-control" name="city" id="city" placeholder="Enter City">
                    <div class="text-danger error-message" data-error-for="city"></div>
                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="{{ route('list_dashboard') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const submitJobUrl = "{{ route('job_apply_store') }}";
const jobIndexUrl = "{{ route('jobs.index') }}";
</script>

<script src="{{ asset('assets\js\trainer\add_job.js') }}"></script>

<style>
.form-check-input:disabled + .form-check-label {
    color: inherit !important;
    opacity: 1 !important;
}
</style>
@endsection
