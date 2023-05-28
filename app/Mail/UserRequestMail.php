<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Institute;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $institute;

    public function __construct(User $user, Institute $institute)
    {
        $this->user = $user;
        $this->institute = $institute;
    }

    public function build()
    {
        return $this->subject('FlowTranslate - New User Request to Join Institute')
            ->markdown('emails.user_request', [
                'user' => $this->user,
                'institute' => $this->institute
            ]);
    }
}
