<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $message;
    public $subject;
    public $fromEmail;
    public $fromName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $message, $subject, $fromEmail)
    {
        $this->name = $name;
        $this->message = $message;
        $this->subject = $subject;
        $this->fromEmail = $fromEmail;
        $this->fromName = env('MAIL_FROM_NAME');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromEmail, $this->fromName)->subject($this->subject)->markdown('mail.general-email')->with([
            'userName' => $this->name,
            'themessage' => $this->message,
        ]);;
    }
}
