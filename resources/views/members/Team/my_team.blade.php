@extends('members.layouts.app')

@section('title', 'Working History')

@section('content')
    <div id="loader">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
    </div>
    <div class="container-custom py-4">
    <div class="container">
        <div class="row g-3">
          <div class="p-4 bg-light rounded shadow">
            <!-- Heading + Add Button -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
                <h4 class="mb-2 mb-md-0">Working Histroy</h4>
                <!-- <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                    <a href="{{ route('add_blogs') }}" class="btn-add">Add Blogs</a>
                    <a href="{{ route('list_deleted_blogs') }}" class="btn-link">Show Deleted Blogs</a>
                </div> -->
            </div>
            <div class="data-wrapper">
                <!-- Filters -->
                <!-- <div class="filters p-3">
                    <div class="row g-3">
                        
                        <div class="col-md-3">
                            <input type="text" id="blogName" class="form-control" placeholder="Blog Name">
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
                    
                    
                        
                    </div>
                </div> -->
                <!-- Separator -->
                <!-- <div class="separator"></div> -->

                <!-- Table -->
                <div class="table-responsive p-3">
                    <table class="table table-hover align-middle custom-table" id="members-table">
                        <thead>
                            <tr>
                                <th>
                                    <a href="#" class="sort-link" data-column="id">
                                        Day 
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="membership_name">
                                        Date
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="duration_in_days">
                                        Total Time
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                              
                              
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
        </div></div>
@endsection


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
<style>
    #members-table thead {
        background-color: #0B1061 !important;
        color: #fff !important;
       
    }
    .container-custom {
        min-height: 90vh;
        background-color: #eee3fb;
        padding: 10px;
        gap: 20px;
        border-radius: 10px;
    }
    .card
    {
        background-color: #f2f2f2 !important;
    }
    .left-panel, .right-panel {

        border-radius: 10px;
        box-shadow:0 4px 12px rgba(0,0,0,0.1);
    }

  
    .fingerprint-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .fingerprint-img {
        width: 120px;
        height: 120px;
        object-fit: contain;
    }

    .date-header {
        font-size: 20px;
    }

    #members-table {
        font-size: 13px;
    }

    #members-table th, #members-table td {
        text-align: center;
        vertical-align: middle;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 10px 0;
    }

    @media (max-width: 768px) {
        .container-custom {
            flex-direction: column;
            align-items: center;
        }

        .left-panel, .right-panel {
            width: 100%;
        }

        .fingerprint-img {
            width: 100px;
            height: 100px;
        }

        .btn {
            padding: 8px 0;
        }
    }
</style>

@push('scripts')
<script>
    const userLoginHistory = "{{ route('user_login_histroy') }}";
   
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/my_team/my_team.js') }}"></script>
<script>

</script>
@endpush
