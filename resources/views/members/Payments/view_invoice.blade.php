@extends('members.layouts.app')

@section('title', 'Invoice')

@section('content')
<div class="container-custom py-4">
    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('member_payments') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            <span class="btn-text">Back</span>
        </a>
    </div>
    <div class="paymentInvoice p-3 p-md-5 rounded-3 shadow-sm mx-auto">

        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div>
                <p class="fw-bold text-theme mb-1 font_size">Invoice Date</p>
                <p class="mb-0 font_size">{{ date('d/m/Y', strtotime($payment->created_at)) }}</p>
            </div>
            <div class="text-center text-md-end">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid" style="height:50px; width:150px; object-fit:cover; border-radius:8px; border:1px solid var(--sidebar_color)">
            </div>
        </div>
        <hr>
        <!-- Bill to -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1 fw-bold  text-theme font_size">Bill to:</p>
                <p class="mb-0 font_size">{{ Auth::user()->first_name ?? 'N/A' }} {{ Auth::user()->last_name ?? '' }}</p> 
                <p class="mb-0 font_size">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </div>

        <p class="mb-4 font_size">Thank you for your payment at <span class="fw-bold text-theme">Sachii</span>. For any queries, please contact us at <a class="fw-bold text-theme" mailto="sjstsabhamumbai@gmail.com">sachii@gmail.com</a>.</p>

        <!-- Invoice Table -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle">
                <thead class="bg-light text-theme">
                    <tr class="fw-bold">
                        <th>Description</th>
                        <th class="text-end">Qty</th>
                        <th class="text-end">Unit Price</th>
                        <th class="text-end">Tax</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $payment->plan_name }}</td>
                        <td class="text-end">1</td>
                        <td class="text-end">₹{{ number_format($payment->amount, 2) }}</td>
                        <td class="text-end">₹0.00</td>
                        <td class="text-end">₹{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="4" class="text-end">Subtotal</td>
                        <td class="text-end">₹{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="4" class="text-end">Payments</td>
                        <td class="text-end">₹{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="4" class="text-end">Balance</td>
                        <td class="text-end">₹0.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer -->
        <div class="text-center mt-4">
            <span class="text-muted mb-0 font_size">Total Amount Paid:</span><span class="fw-bold text-theme mb-2 font_size"> ₹{{ number_format($payment->amount, 2) }}</span> <span class="text-muted mb-0 font_size">We appreciate your payment</span>
        </div>

    </div>
</div>
@endsection

<style>
      .btn-back {
        display: inline-flex;
        align-items: center; 
        gap: 6px; 
        text-decoration: none;
        color: #0B1061;
        font-weight: 500;
    }

    .btn-back:hover {
        color: #05093a;
    }

    .btn-back i {
        font-size: 18px;
        line-height: 1;
    }

    .btn-text {
        font-size: 14px;
        line-height: 1;
    }

    .container-custom {
        min-height: 80vh;
        padding: 20px;
        background-color: #f5f6fa;
        border-radius: 12px;
    }
    .text-theme {
        color: #0B1061 !important;
    }
    .paymentInvoice {
        width: 100%;
        background: #f7f7f7;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); 
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid #e0e0e0;
    }
    .paymentInvoice:hover {
        /* transform: translateY(-3px); */
        box-shadow: 0 8px 20px rgba(11, 16, 97, 0.25);
        /* border-color: #0B1061; */
    }
    .table th, .table td {
        vertical-align: middle;
        font-size: 12px;
    }
    .table thead th {
        background-color: #c9c9c9;
        color: #0B1061;
    }
    .table tfoot td {
        background-color: #f8f9fa;
    }
    .fw-bold {
        font-weight: 600 !important;
    }
    .font_size
    {
        font-size: 12px;
    }
    @media (max-width: 768px) {
        .paymentInvoice {
            padding: 1.5rem;
        }
        .btn-text {
            text-align: left !important;
            margin-left: 0 !important;
            padding-left: 5px !important;
        }
        .mb-3 {
        text-align: left !important;
        }
    }
    @media (max-width: 768px) {
    .paymentInvoice {
        padding: 1.2rem;
    }

    /* 1️⃣ Logo & Invoice date in one line */
    .paymentInvoice .d-flex.flex-column.flex-md-row {
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 10px;
    }

    .paymentInvoice img {
        height: 35px !important;
        width: 100px !important;
    }

    .paymentInvoice p.font_size {
        font-size: 11px !important;
        margin-bottom: 2px !important;
    }

    /* 2️⃣ Thank you text smaller + justified */
    .paymentInvoice p.mb-4.font_size {
        font-size: 11px !important;
        text-align: justify !important;
        line-height: 1.4;
    }

    /* 3️⃣ Bill to section smaller + lighter */
    .paymentInvoice .row.mb-3 p {
        font-size: 11px !important;
        font-weight: 400 !important;
        line-height: 1.4;
    }

    .btn-text {
        text-align: left !important;
        margin-left: 0 !important;
        padding-left: 5px !important;
    }
    .mb-3 {
        text-align: left !important;
    }

    .table th, .table td {
        font-size: 10px !important;
        padding: 4px 6px !important;
    }
    .table thead th {
        font-size: 10.5px !important;
    }
    .table tfoot td {
        font-size: 10.5px !important;
    }

    /* Optional: horizontal scroll for small screens */
    .table-responsive {
        border-radius: 6px;
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
    }

}
</style>
