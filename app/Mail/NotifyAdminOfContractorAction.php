<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyAdminOfContractorAction extends Mailable
{
    use Queueable, SerializesModels;

    public $contractor;
    public $action;
    public $interpretation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contractor, $action, $interpretation)
    {
        $this->contractor = $contractor;
        $this->action = $action;
        $this->interpretation = $interpretation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contractor Action Notification')
            ->markdown('emails.admin.notify-action')
            ->with([
                'contractor' => $this->contractor,
                'action' => $this->action,
                'interpretation' => $this->interpretation,
            ]);
    }
}
