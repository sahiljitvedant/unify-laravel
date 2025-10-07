@extends('members.layouts.app')

@section('title', 'Invoice')

@section('content')
<div class="container-custom py-4">
    <div class="paymentInvoice p-3 p-md-5 bg-white rounded-3 shadow-sm mx-auto">

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

        <!-- Bill to -->
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1 fw-bold  text-theme font_size">Bill to:</p>
                <p class="mb-0 font_size">{{ Auth::user()->first_name ?? 'N/A' }} {{ Auth::user()->last_name ?? '' }}</p> 
                <p class="mb-0 font_size">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </div>

        <p class="mb-4 font_size">Thank you for your payment at <span class="fw-bold text-theme">Sachii</span>. For any queries, please contact us at <a clas="fw-bold text-theme" href="mailto:sjstsabhamumbai@gmail.com">sachii@gmail.com</a>.</p>

        <!-- Invoice Table -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle">
                <thead class="bg-light text-theme">
                    <tr class="fw-bold">
                        <th>Description</th>
                        <th class="text-end">Qty</th>
                        <th class="text-end">Unit Price</th>
                        <th class="text-end">Discount</th>
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
                        <td class="text-end">₹0.00</td>
                        <td class="text-end">₹{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="5" class="text-end">Subtotal</td>
                        <td class="text-end">₹{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="5" class="text-end">Payments</td>
                        <td class="text-end">₹{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="5" class="text-end">Balance</td>
                        <td class="text-end">₹0.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer -->
        <div class="text-center mt-4">
            <h4 class="fw-bold text-theme mb-2 font_size">Total Amount Paid: ₹{{ number_format($payment->amount, 2) }}</h4>
            <p class="text-muted mb-0 font_size">We appreciate your payment. If you have any questions, contact our <a class="fw-bold text-theme" href="mailto:sjstsabhamumbai@gmail.com">support team</a>.</p>
        </div>

    </div>
</div>
@endsection

<style>
.container-custom {
    min-height: 80vh;
    padding: 20px;
    background-color: #f5f6fa;
}
.text-theme {
    color: #0B1061 !important;
}
.paymentInvoice {
    max-width: auto;
}
.table th, .table td {
    vertical-align: middle;
    font-size: 12px;
}
.table thead th {
    background-color: #f2f2f2;
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
    font-size: 13px;
}
@media (max-width: 768px) {
    .paymentInvoice {
        padding: 1.5rem;
    }
}
</style>
