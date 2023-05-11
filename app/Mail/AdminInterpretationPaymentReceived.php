<?php

namespace App\Mail;

use App\Models\Interpretation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminInterpretationPaymentReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $interpretation;
    public $subject;
    public $fromEmail;

    public function __construct(Interpretation $interpretation, $subject, $fromEmail)
    {
        $this->interpretation = $interpretation;
        $this->subject = $subject;
        $this->fromEmail = $fromEmail;
    }

    public function build()
    {
        return $this->from($this->fromEmail)
            ->subject($this->subject)
            ->markdown('emails.admin-interpretation-payment-received');
    }
}
