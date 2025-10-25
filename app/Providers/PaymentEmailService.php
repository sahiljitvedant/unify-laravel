<?php

namespace App\Services;

use App\Mail\PaymentInvoiceMail;
use Illuminate\Support\Facades\Mail;

class PaymentEmailService
{
    /**
     * Send payment invoice email
     *
     * @param object $payment
     * @param string $pdfUrl
     * @param string $toEmail
     */
    public static function sendInvoice($payment, $pdfUrl, $toEmail)
    {
        Mail::to($toEmail)->send(new PaymentInvoiceMail($payment, $pdfUrl));
    }
}
