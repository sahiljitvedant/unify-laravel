@extends('layouts.app')

@section('title', 'Testimonials List')

@section('content')
<div id="loader">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_testimonials') }}">Testimonials</a></li>
            <li class="breadcrumb-item active">List Testimonials</li>
        </ol>
    </nav>

    <div class="p-4 bg-light rounded shadow">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <h4 class="mb-2 mb-md-0">List Testimonials</h4>
            <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                <a href="{{ route('add_testimonial') }}" class="btn-add">Add Testimonial</a>
                <a href="{{ route('list_deleted_testimonials') }}" class="btn-link">Show Deleted Testimonials</a>
            </div>
        </div>

        <div class="data-wrapper">

            <!-- Filters -->
            <div class="filters p-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" id="clientName" class="form-control" placeholder="Client Name">
                    </div>
                    <div class="col-md-3">
                        <select id="filterStatus" class="form-control">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="submitBtn" class="btn"><i class="bi bi-search"></i></button>
                        <button id="btnCancel" class="btn btn-secondary cncl_btn"><i class="bi bi-x-circle"></i></button>
                    </div>
                </div>
            </div>

            <div class="separator"></div>

            <!-- Table -->
            <div class="table-responsive p-3">
                <table class="table table-hover align-middle custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="testimonialBody"></tbody>
                </table>
            </div>

            <nav class="pb-3">
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const fetchTestimonials = "{{ route('fetch_testimonials') }}";
    const deleteTestimonial = "{{ route('delete_testimonial', ':id') }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/testimonials/list_testimonials.js') }}"></script>
@endpush
