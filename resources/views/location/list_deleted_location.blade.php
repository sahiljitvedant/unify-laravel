@extends('layouts.app')

@section('title', 'Deleted Location List')

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
                    <a href="{{ route('list_locations') }}">Locations</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    List Deleted Locations
                </li>
            </ol>
        </nav>

        <div class="p-4 bg-light rounded shadow">

            <!-- Heading -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
                <h4 class="mb-2 mb-md-0">List Deleted Locations</h4>
            </div>

            <div class="data-wrapper">

                <!-- Filters -->
                <div class="filters p-3">
                    <div class="row g-3">

                        <div class="col-md-3">
                            <input type="text"
                                   id="locationName"
                                   class="form-control"
                                   placeholder="Location Name">
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

                <div class="separator"></div>

                <!-- Table -->
                <div class="table-responsive p-3">
                    <table class="table table-hover align-middle custom-table">
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
                                    <a href="#" class="sort-link" data-column="location_name">
                                        Location Name
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

                        <tbody id="locationBody"></tbody>
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
    const fetchDeletedLocationsUrl = "{{ route('fetch_deleted_locations') }}";
    const activateLocationUrl = "{{ route('activate_location', ':id') }}";
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/location/list_deleted_location.js') }}"></script>
@endpush
