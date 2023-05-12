<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\ProofReaderOrders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailToProofReader extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $subject;
    public $fromEmail;
    public $fromName;

    public $proofRead;
    /**
     * Create a new message instance.
     *
     * @return void
     *
     */
    public function __construct(Order $order, ProofReaderOrders $proofRead, $subject, $fromEmail)
    {
        $this->order = $order;
        $this->subject = $subject;
        $this->fromEmail = $fromEmail;
        $this->proofRead = $proofRead;
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
            ->subject($this->subject)->markdown('emails.orderToProofReader');
    }
}
