@extends('members.layouts.app')

@section('title', 'Member Login')

@section('content')
<div class="container-custom d-flex flex-wrap justify-content-center align-items-start py-4 gap-3">

    <!-- Left Panel -->
    <div class="left-panel p-4 d-flex flex-column align-items-center">
      

        <!-- Fingerprint -->
        <div class="fingerprint-container mb-4 text-center">
            <img src="{{ asset('assets/img/fingurtip.png') }}" alt="Fingerprint" class="fingerprint-img">
            <div class="mt-2 fw-bold">Active</div>
        </div>

        <!-- Buttons -->
        <div class="d-flex gap-2 w-100">
            <button class="btn btn-success flex-fill" {{ $loginDisabled ? 'disabled' : '' }}>Login</button>
            <button class="btn btn-danger flex-fill" {{ $logoutDisabled ? 'disabled' : '' }}>Logout</button>
        </div>
    </div>


    <div class="right-panel p-4 flex-fill">
    <div class="date-header mb-3 text-center fw-bold">22 Sept 2025</div>

    <!-- Table -->
    <div class="table-responsive p-3">
        <table class="table table-hover align-middle custom-table" id="members-table">
            <thead>
                <tr>
                    <th><a href="#" class="sort-link" data-column="id">ID <span class="sort-icons"><i class="asc">▲</i><i class="desc">▼</i></span></a></th>
                    <th><a href="#" class="sort-link" data-column="log_in_time">Login Time <span class="sort-icons"><i class="asc">▲</i><i class="desc">▼</i></span></a></th>
                    <th><a href="#" class="sort-link" data-column="log_out_time">Logout Time <span class="sort-icons"><i class="asc">▲</i><i class="desc">▼</i></span></a></th>
                </tr>
            </thead>
            <tbody id="loginBody"></tbody>
        </table>
    </div>

    <!-- Pagination -->
    <ul id="pagination" class="pagination justify-content-center mt-3"></ul>
</div>


</div>
@endsection

@push('styles')

<style>
    .container-custom {
        min-height: 90vh;
        background-color: #f4f6f9;
        padding: 20px;
        gap: 20px;
    }

    .left-panel, .right-panel {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .left-panel {
        max-width: 350px;
        width: 100%;
    }

    .right-panel {
        flex: 1;
        min-width: 350px;
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
@endpush

@push('scripts')
<script>
    const LogIN  = "{{ route('member_login_action') }}";
    const fetchLogin  = "{{ route('fetch_member_login') }}";
    const USER_ID = {{ auth()->user()->id }};
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/member_login/member_login.js') }}"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
@endpush
