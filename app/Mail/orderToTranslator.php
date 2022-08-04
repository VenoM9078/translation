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
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $zipName)
    {
        $this->order = $order;
        $this->zipName = $zipName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */


    public function build()
    {
        return $this->markdown('emails.orderToTranslator')->attach(public_path('compressed/' . $this->zipName));
    }
}
