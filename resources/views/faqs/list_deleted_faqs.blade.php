@extends('layouts.app')

@section('title', 'FAQ Deleted List')

@section('content')
    <div id="loader">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
    </div>
    <div class="container-custom">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('list_faqs') }}">FAQ's</a></li>
                <li class="breadcrumb-item" aria-current="page">List Deleted FAQ's</li>
            </ol>
        </nav>
        <div class="p-4 bg-light rounded shadow">
            <!-- Heading + Add Button -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
                <h4 class="mb-2 mb-md-0">List Deleted FAQ's</h4>
                <!-- <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                    <a href="{{ route('add_faq') }}" class="btn-add">Add FAQS</a>
                    <a href="{{ route('list_deleted_membership') }}" class="btn-link">Show Deleted FAQ</a>
                </div> -->
            </div>
            <div class="data-wrapper">
                <!-- Filters -->
                <div class="filters p-3">
                    <div class="row g-3">
                        <!-- Row 1 -->
                        <div class="col-md-3">
                            <input type="text" id="question_name" class="form-control" placeholder="Question Name">
                        </div>
                        <div class="col-md-3">
                            <select id="filterActive" class="form-control">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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

                    <div class="row g-3 mt-2">
                        <!-- Row 2 -->
                        
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
@push('scripts')
<script>
    const fetchMembership = "{{ route('fetch_deleted_faqs') }}";
    const activateMembershipUrl = "{{ route('activate_faqs', ':id') }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/faqs/list_deleted_membership.js') }}"></script>
@endpush
