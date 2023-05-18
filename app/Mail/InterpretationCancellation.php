<?php

namespace App\Mail;

use App\Models\Interpretation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InterpretationCancellation extends Mailable
{
    use Queueable, SerializesModels;

    public $interpretation;

    /**
     * Create a new message instance.
     *
     * @return void
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
        return $this->markdown('emails.interpretation-cancellation')
            ->subject('FlowTranslate - Interpretation Cancelled');
    }
}
