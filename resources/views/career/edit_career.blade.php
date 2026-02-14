@extends('layouts.app')

@section('title', 'Edit Career')

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
            <li class="breadcrumb-item active">Edit Career</li>
        </ol>
    </nav>

    <form id="career_edit_form" class="p-4 bg-light rounded shadow">
        <h4 class="mb-4">Edit Career</h4>

        <div class="row g-3">

<!-- Designation -->
<div class="col-12">
    <label class="form-label required">Designation</label>
    <input type="text" class="form-control" name="designation"
        value="{{ old('designation', $career->designation) }}">
    <div class="text-danger error-message" data-error-for="designation"></div>
</div>

<!-- Years of Experience -->
<div class="col-md-6">
    <label class="form-label required">Years of Experience</label>
    <input type="number" class="form-control" name="years_of_experience"
        value="{{ old('years_of_experience', $career->years_of_experience) }}">
    <div class="text-danger error-message" data-error-for="years_of_experience"></div>
</div>

<!-- Vacancies -->
<div class="col-md-6">
    <label class="form-label required">Number of Vacancies</label>
    <input type="number" class="form-control" name="vacancies"
        value="{{ old('vacancies', $career->vacancies) }}">
    <div class="text-danger error-message" data-error-for="vacancies"></div>
</div>

<!-- Application Start Date -->
<div class="col-md-6">
    <label class="form-label required">Application Start Date</label>
    <input type="date" class="form-control" name="application_start_date"
        value="{{ old('application_start_date', $career->application_start_date) }}">
    <div class="text-danger error-message" data-error-for="application_start_date"></div>
</div>

<!-- Application End Date -->
<div class="col-md-6">
    <label class="form-label required">Application End Date</label>
    <input type="date" class="form-control" name="application_end_date"
        value="{{ old('application_end_date', $career->application_end_date) }}">
    <div class="text-danger error-message" data-error-for="application_end_date"></div>
</div>

<!-- Location -->
<div class="col-md-6">
    <label class="form-label required">Location</label>
    <input type="text" class="form-control" name="location"
        value="{{ old('location', $career->location) }}">
    <div class="text-danger error-message" data-error-for="location"></div>
</div>

<!-- Work Type -->
<div class="col-md-6">
    <label class="form-label required">Work Type</label>
    <select class="form-control" name="work_type">
        <option value="wfo" {{ $career->work_type === 'wfo' ? 'selected' : '' }}>Work From Office</option>
        <option value="wfh" {{ $career->work_type === 'wfh' ? 'selected' : '' }}>Work From Home</option>
        <option value="remote" {{ $career->work_type === 'remote' ? 'selected' : '' }}>On Field</option>
    </select>
    <div class="text-danger error-message" data-error-for="work_type"></div>
</div>

<!-- Job Description -->
<!-- Job Description -->
<div class="col-12">
    <label class="form-label required">Job Description</label>
    <textarea id="job_description" class="form-control" name="job_description">
        {{ old('job_description', $career->job_description) }}
    </textarea>
    <div class="text-danger error-message" data-error-for="job_description"></div>
</div>


<!-- Status -->
<div class="col-md-6">
    <label class="form-label required">Status</label>
    <select class="form-control" name="status">
        <option value="1" {{ $career->status == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ $career->status == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
    <div class="text-danger error-message" data-error-for="status"></div>
</div>

</div>


        <!-- Buttons -->
        <div class="text-end mt-4">
            <a href="{{ route('list_careers') }}" class="btn btn-secondary me-2 cncl_btn">
                Cancel
            </a>
            <button type="submit" class="btn" id="submitBtn">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
@push('scripts')

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

<script>
    const submitCareerPage = "{{ route('update_career', $career->id) }}";
</script>

<script src="{{ asset('assets/js/career/edit_career.js') }}"></script>
@endpush
