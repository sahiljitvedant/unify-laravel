<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiry;
   

    /**
     * Create a new message instance.
     */
    public function __construct($enquiry)
    {
        $this->enquiry = $enquiry;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return $this->subject('Reply to your enquiry ' . $this->enquiry->request_id)
        ->view('emails.reply_enquiry');
    }
}
