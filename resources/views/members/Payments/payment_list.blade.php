@extends('members.layouts.app')

@section('title', 'My Payments')

@section('content')
<div class="container-custom py-4">
    <div class="container">
        <div id="loader" style="display:none;">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Loading..." class="loader-img">
        </div>
        <h4 class="mb-2 mb-md-0 text-theme fw-bold">My Payments</h4>
        <div class="data-wrapper mt-3">
            
            <!-- Filters -->
            <div class="filters p-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <select id="plan_name" class="form-control">
                            <option value="">Select Plan</option>
                            @foreach($memberships as $id => $name)
                                <option value="{{ $name }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="invoice_number" class="form-control" placeholder="Invoice Number">
                    </div>
                    <div class="col-md-3">
                        <input type="number" id="amount" class="form-control" placeholder="Amount (₹)">
                    </div>
                    <div class="col-md-3">
                        <select id="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="success">Success</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-2">
                    <button type="button" id="btnSearch" class="btn">
                        <i class="bi bi-search"></i> 
                    </button>

                    <button type="button" id="btnCancel" class="btn btn-secondary me-1 cncl_btn">
                        <i class="bi bi-x-circle"></i> 
                    </button>

                    </div>
                </div>
            </div>

            <!-- Separator -->
            <div class="separator"></div>

            <div class="payments-cards-wrapper p-3" id="paymentsCards">
            <!-- Cards will be injected here -->
            </div>

            <!-- Pagination -->
            <nav class="pb-3">
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </nav>

        </div>
    </div>
</div>

@endsection
<style>
    .card-body {
        font-size: 12px; 
    }
    .card:hover {
        transform: translateY(-5px); 
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }

    .view-btn i {
        font-size: 0.9rem; 
    }
    .text-theme {
    color: #0B1061 !important;
    }
        .container-custom {
        min-height: 80vh;
        background-color: #f5f6fa;
        padding: 20px;
        border-radius: 12px;
    }

    .search-input {
        min-width: 200px;
        border-radius: 50px;
        padding: 8px 16px;
        border: 1px solid #ccc;
    }

    #membersContainer .card {
        display: flex;
        flex-direction: column;
        align-items: center; /* centers the image & name */
        background-color: #f2f2f2;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        padding: 20px 10px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    #membersContainer .card img {
        border-radius: 50%;
        /* border: 1px solid #0B1061; */
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

    .btn-primary {
        background-color: #0B1061;
        border-radius: 50px;
        padding: 6px 18px;
        border: none;
    }

    .btn-primary:hover {
        background-color: #090d4a;
    }

    .btn-secondary {
        border-radius: 50px;
        padding: 6px 18px;
    }
    .my_team_card
    {
        text-decoration: none;
    }
    #payments-table thead th {
        font-size: 12px;
        font-weight: 600;
        color: #0B1061; /* your theme color */
        vertical-align: middle;
    }

    /* Table body styling */
    #paymentsBody td {
        font-size: 12px;
        color: #333;
        vertical-align: middle;
    }
    body .text-primary {
        color: #0B1061 !important;
    }
    .text-primary, .text-primary * {
        color: #0B1061 !important;
    }
    .view-btn {
        display: inline-flex;         
        align-items: center;
        justify-content: center;
        width: 60px;                
        height: 28px;                 
        border-radius: 50px;           
        background-color: #0B1061;      /* theme color */
        color: #fff;
        font-size: 11px;              
        font-weight: normal;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .download-btn {
        display: inline-flex;         
        align-items: center;
        justify-content: center;
        width: 80px;                
        height: 28px;                 
        border-radius: 50px;           
        background-color: #0B1061;      /* theme color */
        color: #fff;
        font-size: 11px;              
        font-weight: normal;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .view-btn:hover {
        /* transform: scale(1.0); */
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        color: #fff;
    }
    .download-btn:hover {
        /* transform: scale(1.1); */
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        color: #fff;
    }

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const fetchmypayments = "{{ route('fetch_member_payments') }}";
    window.assetBase = "{{ asset('') }}";
   
</script>

<script src="{{ asset('assets/js/member_payment/payment_list.js') }}"></script>

