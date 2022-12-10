<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


// public function __construct(Order $order, $zipName, $zipName2)
//     {
//         $this->order = $order;
//         $this->zipName = $zipName;
//         $this->zipName2 = $zipName2;
//     }

//     /**
//      * Build the message.
//      *
//      * @return $this
//      */


//     public function build()
//     {
//         return $this->markdown('emails.orderToProofReader')
//         ->attach(public_path('compressed/' . $this->zipName))
//         ->attach(public_path('compressed/' . $this->zipName2));
//     }

class mailOfCompletion extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $zipName2;
    public $subject;
    public $fromEmail;
    public $fromName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $zipName2, $subject, $fromEmail)
    {
        $this->order = $order;
        $this->zipName2 = $zipName2;
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
            ->subject($this->subject)->markdown('emails.mailOfCompletion')
            ->attach(public_path('translated/' . $this->zipName2));;
    }
}
