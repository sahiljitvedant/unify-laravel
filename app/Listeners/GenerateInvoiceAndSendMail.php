<?php

namespace App\Listeners;

use App\Events\PaymentCompleted;
use App\Services\PaymentEmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use PDF;

class GenerateInvoiceAndSendMail implements ShouldQueue
{
    public function handle(PaymentCompleted $event)
    {
        $payment = $event->payment;

        // Generate PDF
        $pdf = PDF::loadView('gym_packages.invoice_pdf', ['payment' => $payment]);
        $fileName = 'invoice_' . $payment->invoice_number . '.pdf';
        $path = 'public/invoices/' . $fileName;

        Storage::put($path, $pdf->output());
        $payment->update(['invoice_path' => 'storage/invoices/' . $fileName]);

        // Send Email
        $email = 'sahilsunilj@gmail.com';
        PaymentEmailService::sendInvoice($payment, 'storage/invoices/' . $fileName, $email);
    }
}
