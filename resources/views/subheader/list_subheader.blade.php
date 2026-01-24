@extends('layouts.app')

@section('title', 'SubHeader List')

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
            <li class="breadcrumb-item active">List SubHeaders</li>
        </ol>
    </nav>

    <div class="p-4 bg-light rounded shadow">

        <!-- Heading + Add Button -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
            <h4>List SubHeaders</h4>

            <div class="d-flex flex-column align-items-md-end gap-2">
                <a href="{{ route('add_subheader') }}" class="btn-add">
                    Add SubHeader
                </a>
                <a href="{{ route('list_deleted_subheaders') }}" class="btn-link">
                    Show Deleted SubHeaders
                </a>
            </div>
        </div>

        <div class="data-wrapper">

            <!-- Filters -->
            <div class="filters p-3">
                <div class="row g-3">

                    <div class="col-md-3">
                        <input type="text"
                               id="subheader_name"
                               class="form-control"
                               placeholder="SubHeader Name">
                    </div>

                    <div class="col-md-3">
                        <select id="headerFilter" class="form-control">
                            <option value="">Select Header</option>
                            @foreach($headers as $header)
                                <option value="{{ $header->id }}">
                                    {{ $header->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="filterActive" class="form-control">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-3">
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
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </nav>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const fetchSubHeadersUrl = "{{ route('fetch_subheaders') }}";
    const deleteSubHeaderUrl = "{{ route('delete_subheader', ':id') }}";
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/subheader/list_subheader.js') }}"></script>
@endpush
