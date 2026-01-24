@extends('layouts.app')

@section('title', 'Job List')

@section('content')
<div id="loader">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Job List</li>
        </ol>
    </nav>

    <div class="p-4 bg-light rounded shadow">
        <!-- Heading + Add Button -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <h4 class="mb-2 mb-md-0">List Job Applications</h4>
            <a href="{{ route('job_apply_form') }}" class="btn-add">Add Job</a>
        </div>

        <div class="data-wrapper">
            <!-- Filters -->
            <div class="filters p-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" id="jobTitle" class="form-control" placeholder="Job Title">
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="city" class="form-control" placeholder="City">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button id="submitBtn" class="btn">
                            <i class="bi bi-search"></i>
                        </button>
                        <button id="btnCancel" class="btn btn-secondary cncl_btn">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="separator"></div>

            <!-- Cards Container -->
            <div class="row g-4 p-3" id="jobCards"></div>

            <!-- Pagination -->
            <nav class="pb-3">
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const fetchJobList = "{{ route('fetch_job_list') }}";
    const deleteJob = "{{ route('delete_job', ':id') }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="{{ asset('assets/js/trainer/jobs_list.js') }}"></script>

@endpush
