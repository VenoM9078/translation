<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterpretationReportToUser extends Mailable
{
    use Queueable, SerializesModels;

    public $interpretation;

    public function __construct($interpretation)
    {
        $this->interpretation = $interpretation;
    }

    public function build()
    {
        return $this->subject('Flow Translation - Interpretation Completed')
            ->markdown('emails.user.interpretationReport', ['interpretation' => $this->interpretation]);
    }
}
