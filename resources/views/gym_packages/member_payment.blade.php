@extends('layouts.app')

@section('title', 'Payment List')

@section('content')
    <div id="loader">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
    </div>
    <div class="container-custom">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="">Payments</a></li>
                <li class="breadcrumb-item" aria-current="page">List Payments</li>
            </ol>
        </nav>
        <div class="p-4 bg-light rounded shadow">
            <!-- Heading + Add Button -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
                <h4 class="mb-2 mb-md-0">List Payment</h4>
                <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                <a href="{{ route('add_member_payment', $id) }}" class="btn-add">Add Payment</a>

                    
                </div>
            </div>
            <div class="data-wrapper">
                <!-- Filters -->
                <div class="filters p-3">
                    <div class="row g-3">
                        <!-- Row 1 -->
                      
                        <div class="col-md-3">
                            <input type="text" id="filterMemberName" class="form-control" placeholder="Enter Members Name">
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="filterEmail" class="form-control" placeholder="Enter Email Address">
                        </div>
                        <div class="col-md-3">
                            <input type="number" id="filterMobile" class="form-control" placeholder="Enter Mobile Number">
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <!-- Row 2 -->
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
                                        Membership name
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="duration_in_days">
                                        Amount Paid
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="price">
                                        Total Amount Paid 
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>Remaining</th>
                                
                                <th>Paid By</th>
                                
                                <th>Download Invoice</th>
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
    /* Scoped invoice buttons inside your table */
</style>
@endpush

@push('scripts')
<script>
   const fetchMemberPayment = "{{ route('fetch_member_payment', $id) }}";

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/gym_package/member_payment.js') }}"></script>
@endpush
