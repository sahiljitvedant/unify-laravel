@extends('layouts.app')

@section('title', 'Membership List')

@section('content')
    <div id="loader">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
    </div>
    <div class="container-custom">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('list_membership') }}">Memberships</a></li>
                <li class="breadcrumb-item" aria-current="page">List Membership</li>
            </ol>
        </nav>
        <div class="p-4 bg-light rounded shadow">
            <!-- Heading + Add Button -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
                <h4 class="mb-2 mb-md-0">List Membership</h4>
                <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                    <a href="{{ route('add_membership') }}" class="btn-add">Add Membership</a>
                    <a href="{{ route('list_deleted_membership') }}" class="btn-link">Show Deleted Membership</a>
                </div>
            </div>
            <div class="data-wrapper">
                <!-- Filters -->
                <div class="filters p-3">
                    <div class="row g-3">
                        <!-- Row 1 -->
                        <div class="col-md-3">
                            <select id="filterActive" class="form-control">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filterTrainer" class="form-control">
                                <option value="">Select Trainer</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <!-- <div class="col-md-3">
                            <input type="number" id="durartion" class="form-control" placeholder="Durartion">
                        </div> -->
                        <div class="col-md-3">
                            <select id="durartion" class="form-control">
                                <option value="">Select Duration</option>
                                <option value="30">1 Month</option>
                                <option value="90">3 Months</option>
                                <option value="180">6 Months</option>
                                <option value="365">1 Year</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" id="price" class="form-control" placeholder="Price">
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <!-- Row 2 -->
                        <div class="col-md-3">
                            <input type="text" id="membership_name" class="form-control" placeholder="Membership name">
                        </div>
                        <div class="col-md-2">
                            <button id="submitBtn" class="btn ">
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
                                    <a href="#" class="sort-link" data-column="membership_name">
                                        Name
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="duration_in_days">
                                        Duration
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="price">
                                        Price
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>Trainer</th>
                                <th>Active</th>
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

@push('styles')
<style>
    .btn-add {
        background-color: #0B1061;
        color: #fff;
        border-radius: 8px;
        padding: 6px 16px;
        border: none;
        text-decoration: none;
        font-size: 14px;
    }
    .btn-add:hover { background-color: #090d4a; }
    th a { color: inherit; text-decoration: none; }

</style>
@endpush

@push('scripts')
<script>
    const fetchMembership = "{{ route('fetch_membership') }}";
    const deleteMembershipUrl = "{{ route('delete_membership', ':id') }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/gym_membership/list_membership.js') }}"></script>
<script>

</script>
@endpush
