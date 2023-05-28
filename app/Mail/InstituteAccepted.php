<?php

namespace App\Mail;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstituteAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $institute;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Institute $institute)
    {
        $this->user = $user;
        $this->institute = $institute;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.institute.accepted')->subject('Flow Translate - Institute Request Accepted');;
    }
}
