<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $payment->invoice_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .text-theme { color: #0B1061 !important; }
       
        .paymentInvoice {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            border: 1px solid #000;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .header img {
            height: 50px;
            width: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        thead th {
            background: #c9c9c9;
            color: #0B1061;
            font-weight: 600;
        }
        tfoot td {
            background: #f8f9fa;
            font-weight: 600;
        }
        .text-end { text-align: right; }
        .fw-bold { font-weight: 600; }
        .font_size { font-size: 12px; }
        .text-center { text-align: center; }
        .thankyou {
            margin-top: 30px;
            font-size: 12px;
            text-align: justify;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container-custom">
        <div class="paymentInvoice">

            <div class="header">
                
                <div>
                    <img src="{{ public_path('assets/img/logo.png') }}" style="height:50px; width:140px; object-fit:cover; border-radius:8px; border:1px solid var(--sidebar_color)" alt="Logo">
                </div>
                <div>
                    <p class="fw-bold text-theme mb-1 font_size">Invoice Date</p>
                    <p class="mb-0 font_size">{{ date('d/m/Y', strtotime($payment->created_at)) }}</p>
                </div>
            </div>
           


            <hr>

            <div style="margin-bottom: 10px;">
                <p class="mb-1 fw-bold text-theme font_size">Bill to:</p>
                <p class="mb-0 font_size">{{ Auth::user()->name ?? 'N/A' }}</p> 
                <p class="mb-0 font_size">{{ Auth::user()->email ?? '' }}</p>
            </div>

            <p class="thankyou">Thank you for your payment at <strong class="text-theme">Brainstar</strong>. 
                For any queries, please contact us at <strong class="text-theme">Brainstar@gmail.com</strong>.
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-end">Qty</th>
                        <th class="text-end">Unit Price</th>
                        <th class="text-end">Tax</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-end">   {{ $payment->membership ? $payment->membership->membership_name : 'N/A' }}</td>
                        <td class="text-end">1</td>
                        <td class="text-end">Rs.{{ number_format($payment->amount, 2) }}</td>
                        <td class="text-end">Rs.0.00</td>
                        <td class="text-end">Rs.{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end">Subtotal</td>
                        <td class="text-end">Rs.{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">Payments</td>
                        <td class="text-end">Rs.{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end">Balance</td>
                        <td class="text-end">Rs.0.00</td>
                    </tr>
                </tfoot>
            </table>

            <div class="text-center" style="margin-top:20px;">
                <span class="text-muted font_size">Total Amount Paid:</span>
                <span class="fw-bold text-theme font_size">Rs.{{ number_format($payment->amount, 2) }}</span>
                <span class="text-muted font_size"> — We appreciate your payment!</span>
            </div>

        </div>
    </div>
</body>
</html>
