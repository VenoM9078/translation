<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class orderToTranslator extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $zipName;

    public $subject;
    public $fromEmail;
    public $fromName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $zipName, $subject, $fromEmail)
    {
        $this->order = $order;
        $this->zipName = $zipName;
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
        return $this->from($this->fromEmail, $this->fromName)
            ->subject($this->subject)->markdown('emails.orderToTranslator')
            ->attach(public_path('compressed/' . $this->zipName));
    }
}
