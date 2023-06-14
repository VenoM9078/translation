<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyContractorMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $contractor;
    public $subject;
    public function __construct($contractor)
    {
        $this->contractor = $contractor;
        $this->subject = "Email Verification | Contractor";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env("ADMIN_EMAIL_DEV"), "Flow Translate")
            ->subject($this->subject)->markdown('emails.contractor.message');
    }
}