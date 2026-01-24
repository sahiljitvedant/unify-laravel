@extends('layouts.app')

@section('title', 'Deleted SubHeader List')

@section('content')
<div id="loader">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('list_dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('list_subheaders') }}">SubHeaders</a>
            </li>
            <li class="breadcrumb-item active">
                List Deleted SubHeaders
            </li>
        </ol>
    </nav>

    <div class="p-4 bg-light rounded shadow">

        <!-- Heading -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>List Deleted SubHeaders</h4>
        </div>

        <div class="data-wrapper">

            <!-- Filters -->
            <div class="filters p-3">
                <div class="row g-3">

                    <div class="col-md-3">
                        <input type="text"
                               id="subheaderName"
                               class="form-control"
                               placeholder="SubHeader Name">
                    </div>

                    <div class="col-md-3">
                        <select id="filterActive" class="form-control">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button id="submitBtn" class="btn">
                            <i class="bi bi-search"></i>
                        </button>

                        <button id="btnCancel"
                                class="btn btn-secondary cncl_btn">
                            <i class="bi bi-x-circle"></i>
                        </button>
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
                            <th>Header</th>
                            <th>SubHeader</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="subheaderBody"></tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav class="pb-3">
                <ul class="pagination justify-content-center"
                    id="pagination"></ul>
            </nav>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const fetchDeletedSubHeaders =
        "{{ route('fetch_deleted_subheaders') }}";

    const activateSubHeader =
        "{{ route('activate_subheader', ':id') }}";
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/subheader/list_deleted_subheader.js') }}"></script>
@endpush
