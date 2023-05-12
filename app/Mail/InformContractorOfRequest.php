<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ContractorInterpretation;

class InformContractorOfRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $contractorInterpretation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContractorInterpretation $contractorInterpretation)
    {
        $this->contractorInterpretation = $contractorInterpretation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.inform-contractor')
            ->with([
                'contractorInterpretation' => $this->contractorInterpretation,
            ]);
    }
}
