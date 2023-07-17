<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContractorNotifyAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $contractorName;
    public $contractorOrder;
    public $isAccepted;
    public function __construct($contractorName, $contractorOrder,$isAccepted)
    {
        $this->contractorName = $contractorName;
        $this->contractorOrder = $contractorOrder;
        $this->isAccepted = $isAccepted;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("webpage@flowtranslate.com")
            ->subject("Translation Order")->markdown('emails.contractorNotifyAdmin');
    }
}