@extends('layouts.app')

@section('title', 'Deleted Testimonials List')

@section('content')
<div id="loader">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('list_testimonials') }}">Testimonials</a></li>
            <li class="breadcrumb-item active">List Deleted Testimonials</li>
        </ol>
    </nav>

    <div class="p-4 bg-light rounded shadow">
        <h4 class="mb-3">List Deleted Testimonials</h4>

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
                            <th><a href="#" class="sort-link" data-column="id">ID <span class="sort-icons"><i class="asc">▲</i><i class="desc">▼</i></span></a></th>
                            <th>Photo</th>
                            <th><a href="#" class="sort-link" data-column="name">Name <span class="sort-icons"><i class="asc">▲</i><i class="desc">▼</i></span></a></th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="testimonialBody"></tbody>
                </table>
            </div>

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
    const fetchTestimonials = "{{ route('fetch_deleted_testimonials') }}";
    const activateTestimonial = "{{ route('activate_testimonial', ':id') }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/testimonials/list_deleted_testimonials.js') }}"></script>
@endpush
