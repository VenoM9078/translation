<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAdminTranslationSubmissionContractor extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $contractorName;
    public $contractorOrder;

    public $order;
    public function __construct($contractorName, $contractorOrder,$order)
    {
        $this->contractorName = $contractorName;
        $this->contractorOrder = $contractorOrder;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))->markdown('emails.notifyAdminAboutContractorTranslation');
    }
}