<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyAdminQuote extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $status;
    public $statusMessage;
    public $fromEmail;
     public function __construct($data,$status,$from)
    {
        $this->data = $data;
        $this->status = $status;
        $this->fromEmail=  $from;
    }
    public function build()
    {
        if($this->status == 1){
            $this->statusMessage = "Approved";
            return $this->from($this->fromEmail,"Flow Translate")
                ->subject('Approved Quote')->markdown('emails.notifyAdminQuote');
        } else {
            $this->statusMessage = "Disapproved";
            return $this->from($this->fromEmail, "Flow Translate")
                ->subject('Approved Quote')->markdown('emails.notifyAdminQuote');

        }
    }
}
