@extends('layouts.app')

@section('title', 'Deleted Header List')

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
                    <a href="{{ route('list_headers') }}">Headers</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    List Deleted Headers
                </li>
            </ol>
        </nav>

        <div class="p-4 bg-light rounded shadow">

            <!-- Heading -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
                <h4 class="mb-2 mb-md-0">List Deleted Headers</h4>
            </div>

            <div class="data-wrapper">

                <!-- Filters -->
                <div class="filters p-3">
                    <div class="row g-3">

                        <div class="col-md-3">
                            <input type="text"
                                   id="headerTitle"
                                   class="form-control"
                                   placeholder="Header Title">
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

                            <button id="btnCancel" class="btn btn-secondary me-1 cncl_btn">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Separator -->
                <div class="separator"></div>

                <!-- Table -->
                <div class="table-responsive p-3">
                    <table class="table table-hover align-middle custom-table" id="members-table">
                        <thead>
                            <tr>
                                <th>
                                    <a href="#" class="sort-link" data-column="id">
                                        ID
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>

                                <th>
                                    <a href="#" class="sort-link" data-column="title">
                                        Header Title
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>

                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="membershipBody"></tbody>
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
    const fetchDeletedHeaders = "{{ route('fetch_deleted_headers') }}";
    const activateHeader = "{{ route('activate_header', ':id') }}";
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/header/list_deleted_header.js') }}"></script>
@endpush
