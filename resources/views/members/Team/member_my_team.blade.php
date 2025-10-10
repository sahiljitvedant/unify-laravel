@extends('members.layouts.app')

@section('title', 'My Team')

@section('content')
<div id="loader" style="display:none;">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
</div>

<div class="container-custom py-4">
    <div class="container">
        <!-- Heading + Search Filter -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-1">
            <div class="row g-4">
                <h4 class="mb-2 mb-md-0 text-theme fw-bold">My Team</h4>
            </div>
            <div class="d-flex gap-2">
                <input type="text" id="searchName" class="form-control" placeholder="Search Name">
                <button id="btnSearch" class="btn text-white" style="background-color:#0B1061;">
                    <i class="bi bi-search"></i>
                </button>
                <button id="btnCancel" class="btn btn-secondary me-1 cncl_btn">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>
        </div>

        <!-- Cards -->
        <div class="row g-3" id="membersContainer"></div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center mt-4" id="paginationLinks"></ul>
        </nav>
    </div>
</div>
@endsection

<style>
    .container-custom {
        min-height: 80vh;
        background-color: #f5f6fa;
        padding: 20px;
        border-radius: 12px;
    }

    .text-theme {
        color: #0B1061 !important;
    }

    #membersContainer .card {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #f2f2f2;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        padding: 20px 10px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    #membersContainer .card img {
        border-radius: 50%;
    }

    #membersContainer .card:hover {
        transform: translateY(-2px);
        cursor: pointer;
    }

    #membersContainer .card h6 {
        margin-top: 10px;
        font-weight: 400;
        color: #000;
        font-size: 12px;
    }

    .my_team_card {
        text-decoration: none;
    }

    /* Pagination theme */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
    }
    .pagination .page-item .page-link {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0B1061;
        border: 1px solid #0B1061;
        background-color: #fff;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .pagination .page-item .page-link:hover {
        background-color: #0B1061;
        color: #fff;
    }
    .pagination .page-item.active .page-link {
        background-color: #0B1061;
        color: #fff;
        border-color: #0B1061;
    }
    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        pointer-events: none;
    }
    .pagination .page-link:focus {
        box-shadow: none;
    }
    .card
    {
        height: 150px !important; /* fixed height — adjust as needed */
        padding: 15px;
        border-radius: 12px;
        background: #f9f9f9;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) 
    {
        /* Title fully left aligned */
        h4.text-theme {
            text-align: left !important;
            margin-left: 0 !important;
            padding-left: 5px !important;
        }
        .row > .col-md-4 {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .card {
            width: 100%;
            margin: 0 auto;
        }
    }
</style>

@push('scripts')
<script>
const userMyTeamRoute = "{{ route('fetch_member_my_team') }}";
window.assetBase = "{{ asset('') }}";
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/my_team/my_team.js') }}"></script>
@endpush
