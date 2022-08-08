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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $zipName2)
    {
        $this->order = $order;
        $this->zipName2 = $zipName2;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.mailOfCompletion')
        ->attach(public_path('compressed/' . $this->zipName2));;
    }
}
