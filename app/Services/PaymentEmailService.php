<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Models\Payment;

class PaymentEmailService
{
    public static function sendInvoice(Payment $payment, string $pdfPath, string $toEmail)
    {
        Mail::to($toEmail)->send(new InvoiceMail($payment, $pdfPath));
    }
}