<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAdminProofRead extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $contractor;
    public $action;
    public $proofRead;
    public function __construct($contractor, $action, $proofRead)
    {
        $this->contractor = $contractor;
        $this->action = $action;
        $this->proofRead = $proofRead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contractor Action Notification | Proof Read')
            ->markdown('emails.admin.notify-action-proofread')
            ->with([
                'contractor' => $this->contractor,
                'action' => $this->action,
                'proofRead' => $this->proofRead,
            ]);
    }
}