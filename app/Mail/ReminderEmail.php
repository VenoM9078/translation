<?php

namespace App\Mail;

use App\Models\Interpretation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $interpretation;

    /**
     * Create a new message instance.
     *
     * @param Interpretation $interpretation
     */
    public function __construct(Interpretation $interpretation)
    {
        $this->interpretation = $interpretation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.admin.remind-interpretation')
            ->with('interpretation', $this->interpretation);
    }

}