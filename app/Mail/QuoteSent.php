<?php

namespace App\Mail;

use App\Models\Interpretation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteSent extends Mailable
{
    use Queueable, SerializesModels;

    public $interpretation;

    public function __construct(Interpretation $interpretation)
    {
        $this->interpretation = $interpretation;
    }

    public function build()
    {
        return $this->markdown('emails.quote-sent');
    }
}
