<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Interpretation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserNewInterpretation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $interpretation;
    public $subject;
    public $fromEmail;
    public $fromName;

    public function __construct(User $user, Interpretation $interpretation, $subject, $fromEmail)
    {
        $this->user = $user;
        $this->interpretation = $interpretation;
        $this->subject = $subject;
        $this->fromEmail = $fromEmail;
        $this->fromName = env('MAIL_FROM_NAME');
    }

    public function build()
    {
        return $this->from($this->fromEmail, $this->fromName)
            ->subject($this->subject)
            ->markdown('emails.userNewInterpretation');
    }
}
