@extends('layouts.app')

@section('title', 'Members List')

@section('content')
    <div id="loader">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
    </div>
    <div id="importLoader" style="display:none;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
    </div>
    <div class="container-custom">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('list_dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('list_member') }}">Members</a></li>
                <li class="breadcrumb-item" aria-current="page">List Members</li>
            </ol>
        </nav>
        <div class="p-4 bg-light rounded shadow">
            <!-- Heading + Add Button -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
                <div class="d-flex flex-column align-items-start align-items-md-start gap-2">
                <h4 class="mb-2 mb-md-0">List Members</h4>
                <a href="javascript:void(0)" id="import-users-link" class="btn-link">Import Members</a>
                    <a href="{{ asset('assets/sample/sample_member.xlsx') }}" 
                        class="btn-link text-primary" 
                        download>
                        <i class="bi bi-download"></i> Download Sample File
                    </a>
                    </div>
                <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                    <a href="{{ route('add_member') }}" class="btn-add">Add Members</a>
                    <a href="{{ route('list_deleted_member') }}" class="btn-link">Show Deleted Members</a>
                    
                </div>
                <form id="import-form" enctype="multipart/form-data" style="display:none;">
                    @csrf
                    <input type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls,.csv">
                </form>
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
                                        Members Name
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="duration_in_days">
                                        Email
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href="#" class="sort-link" data-column="price">
                                        Mobile
                                        <span class="sort-icons">
                                            <i class="asc">▲</i>
                                            <i class="desc">▼</i>
                                        </span>
                                    </a>
                                </th>
                               
                               
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
    #importLoader {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(255,255,255,0.9);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.import-loader-overlay {
    text-align: center;
}

.spinner {
    width: 60px;
    height: 60px;
    border: 6px solid #e0e0e0;
    border-top: 6px solid #0B1061;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.import-loader-text {
    color: #0B1061;
    font-weight: 500;
}

</style>

@endpush

@push('scripts')
<script>
    const fetchMembership = "{{ route('fetch_member_list') }}";
    const deleteMembershipUrl = "{{ route('delete_members', ':id') }}";
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/gym_package/list_members.js') }}"></script>

<script>
    $(document).ready(function() 
    {
        $('#import-users-link').on('click', function() {
            $('#excel_file').click();
        });

        $('#excel_file').on('change', function() {
    let formData = new FormData($('#import-form')[0]);
    
    $("#loader").show(); // show import loader

    $.ajax({
        url: "{{ route('import_members') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(res) {
            $("#loader").hide(); // hide loader on success
            Swal.fire('Success', 'Users imported successfully!', 'success').then(() => {
                $('#excel_file').val('');
                location.reload();
            });
        },
        error: function(err) {
            $("#loader").hide(); // hide loader on error
            console.error(err);
            Swal.fire('Error', 'Failed to import users!', 'error').then(() => {
                $('#excel_file').val('');
            });
        }
    });
});

    });
</script>


@endpush
