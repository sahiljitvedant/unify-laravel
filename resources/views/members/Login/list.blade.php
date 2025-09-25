@extends('members.layouts.app')

@section('title', 'Member Login')

@section('content')
<div class="container-custom py-4">
    <div class="container">
        <div class="row g-3">
            <!-- Left Panel as Card -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column align-items-center">
                        <!-- Fingerprint -->
                        <div class="fingerprint-container mb-4 text-center">
                            <img src="{{ asset('assets/img/fingurtip.png') }}" alt="Fingerprint" class="fingerprint-img">
                            <div class="mt-2 fw-bold">     
                                @if($loginRecord)
                                    {{ $loginRecord->status == 1 ? 'User is Logged In' : 'User is Logged Out' }}
                                @else
                                    No login record found for today
                                @endif
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 w-100 mt-auto">
                            <button id="nextBtn" class="btn btn-success flex-fill" {{ $loginDisabled ? 'disabled' : '' }}>Login</button> 
                            <button id="nextBtn" class="btn btn-danger flex-fill" {{ $logoutDisabled ? 'disabled' : '' }}>Logout</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel as Card -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <div class="date-header mb-3 text-center fw-bold">
                            {{ \Carbon\Carbon::now()->format('d M Y') }}
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle custom-table" id="members-table">
                                <thead>
                                    <tr>
                                        <th>Login Time</th>
                                        <th>Logout Time</th>
                                        <th>Total Time</th>
                                        <th>Total Time</th>
                                    </tr>
                                </thead>
                                <tbody id="loginBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full-width Summary Section -->
        <!-- <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Summary Section</h5>
                        <p class="card-text text-muted">
                            This is a static card (col-12 size). You can use it for 
                            showing total login hours, extra information, or any 
                            other details you want to display.
                        </p>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-center mb-3">Summary Section</h5>

                        <!-- Static Table -->
                        <div class="table-responsive">
                           
                            <table class="table table-hover align-middle custom-table" id="members-table-2">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Date</th>
                                        <th>Total Time</th>
                                    
                                    </tr>
                                </thead>
                                <tbody id="loginBodyDeatil"></tbody>
                            </table>
                           
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection



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
    const LogIN  = "{{ route('member_login_action') }}";
    const fetchLogin  = "{{ route('fetch_member_login') }}";
    const fetchLogin2  = "{{ route('fetch_member_login_detail') }}";

    const USER_ID = {{ auth()->user()->id }};
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/member_login/member_login.js') }}"></script>



@endpush
