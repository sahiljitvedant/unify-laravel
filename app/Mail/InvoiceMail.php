<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;
class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $pdfPath;

    public function __construct(Payment $payment, string $pdfPath)
    {
        $this->payment = $payment;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Your Membership Invoice')
                    ->view('emails.invoice')
                    ->attach(storage_path('app/public/invoices/' . basename($this->pdfPath)));
    }
}
