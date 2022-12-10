<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class invoiceSent extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $order;
    public $invoice;

    public $subject;
    public $fromEmail;
    public $fromName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Order $order, Invoice $invoice, $subject, $fromEmail)
    {
        $this->user = $user;
        $this->order = $order;
        $this->invoice = $invoice;
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
            ->subject($this->subject)->markdown('emails.invoiceSent');
    }
}
