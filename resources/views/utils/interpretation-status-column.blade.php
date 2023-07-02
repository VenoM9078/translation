@if (Auth::user()->getTable() != 'admins')
    {{-- Status for Users --}}
    @if ($interpretation->is_cancelled == 1)
        <div class="w-full btn btn-danger">
            Cancelled
        </div>
    @elseif (
        $interpretation->added_by_institute_user == 1 &&
            $interpretation->interpreter_id === null &&
            $interpretation->interpreter_completed == 0)
        <div class="w-full btn btn-warning">
            Waiting for Interpreter
        </div>
    @elseif (
        $interpretation->added_by_institute_user == 1 &&
            $interpretation->interpreter_id != null &&
            $interpretation->interpreter_completed == 0)
        <div class="w-full btn btn-warning">

            Interpreter Confirmed
        </div>
    @elseif (
        $interpretation->added_by_institute_user == 1 &&
            $interpretation->interpreter_id != null &&
            $interpretation->interpreter_completed == 1)
        <div class="w-full btn btn-success">

            Interpretation Completed
        </div>
    @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 && $interpretation->paymentStatus == 0)
        <div class="w-full btn btn-warning">

            Payment Required
        </div>
    @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 && $interpretation->paymentStatus == 0)
        <div class="w-full btn btn-warning">

            Waiting for Payment
        </div>
    @elseif (
        $interpretation->wantQuote == 3 &&
            $interpretation->invoiceSent == 1 &&
            $interpretation->paymentStatus == 1 &&
            $interpretation->interpreter_id === null &&
            $interpretation->interpreter_completed == 0)
        <div class="w-full btn btn-success">

            Payment Confirmed
        </div>
    @elseif (
        $interpretation->wantQuote == 3 &&
            $interpretation->invoiceSent == 1 &&
            $interpretation->paymentStatus == 1 &&
            $interpretation->interpreter_id !== null &&
            $interpretation->interpreter_completed == 0)
        <div class="w-full btn btn-success">

            Interpreter Confirmed
        </div>
    @elseif (
        $interpretation->wantQuote == 3 &&
            $interpretation->invoiceSent == 1 &&
            $interpretation->paymentStatus == 1 &&
            $interpretation->interpreter_id !== null &&
            $interpretation->interpreter_completed == 1)
        <div class="w-full btn btn-success">

            Interpretation Completed
        </div>
    @elseif ($interpretation->wantQuote == 1)
        <div class="w-full btn btn-success">

            Quote Requested
        </div>
    @elseif ($interpretation->wantQuote == 2)
        <div class="w-full btn btn-warning">

            Quote Ready
        </div>
    @elseif (
        $interpretation->wantQuote == 3 &&
            $interpretation->paymentStatus == 1 &&
            $interpretation->interpreter_id === null &&
            $interpretation->interpreter_completed == 0)
        <div class="w-full btn btn-success">

            Payment Confirmed
        </div>
    @elseif (
        $interpretation->wantQuote == 3 &&
            $interpretation->paymentStatus == 1 &&
            $interpretation->interpreter_id !== null &&
            $interpretation->interpreter_completed == 0)
        <div class="w-full btn btn-success">

            Interpreter Confirmed
        </div>
    @elseif (
        $interpretation->wantQuote == 3 &&
            $interpretation->paymentStatus == 1 &&
            $interpretation->interpreter_id !== null &&
            $interpretation->interpreter_completed == 1)
        <div class="w-full btn btn-success">

            Interpretation Completed
        </div>
    @endif
@else
    {{-- Status for FT Admin --}}
    {{--
         wantQuote 
          0 -> no
         1 -> yes
         2 -> sent  
        --}}
    {{-- Interpretation pending/not completed --}}
    @if ($interpretation->interpreter_completed == 0)
        @if ($interpretation->is_cancelled == 1)
            <div class="w-full btn btn-danger">
                Cancelled
            </div>
        @elseif (
            $interpretation->wantQuote == 0 &&
                ($interpretation->user->role_id == 1 || $interpretation->user->role_id == 2) &&
                $interpretation->interpreter_id == null)
            <div class="w-full btn btn-warning">
                Interpretation Requested
            </div>
        @elseif ($interpretation->wantQuote == 1 && !isset($interpretation->interpreter))
            {{--   
         "Quote Requested" is set, if a new order is submitted with requesting a quote.
     --}}
            <div class="w-full btn btn-warning">
                Quote Requested
            </div>
        @elseif(
            $interpretation->wantQuote == 2 &&
                $interpretation->is_order_quote_accepted == \App\Enums\OrderStatusEnum::QUOTEACCEPTED &&
                !isset($interpretation->interpreter))
            {{-- 
                " Approved" is set, when client approve the quote. 
            --}}
            <div class="w-full btn btn-success">
                Quote Approved
            </div>
        @elseif($interpretation->wantQuote == 1)
            {{-- 
            "Quote Ready" is set, if FT admin uploads a quote  (or generates quotes with a template form - TBD) to website. 
            --}}
            <div class="w-full btn btn-success">
                Quote Ready
            </div>
        @elseif($interpretation->paymentStatus == 0 && $interpretation->wantQuote == 0)
            {{-- 
            "Payment Required" is set, if a new order is submitted without requesting a quote by individual user.  
        --}}
            <div class="w-full btn btn-warning">
                Payment Required
            </div>
        @elseif (isset($interpretation->contractorInterpretation) &&
                $interpretation->contractorInterpretation->is_accepted == 0 &&
                $interpretation->interpreter_id == null)
            <div class="w-full btn btn-success">
                Interpreter Assigned
            </div>
        @elseif (isset($interpretation->contractorInterpretation) &&
                $interpretation->contractorInterpretation->is_accepted == 1 &&
                $interpretation->interpreter_id != null)
            <div class="w-full btn btn-success">
                Interpreter Confirmed
            </div>
        @elseif(
            ($interpretation->paymentStatus == 1 || $interpretation->paymentStatus == 2) &&
                $interpretation->interpreter_completed == 0)
            <div class="w-full btn btn-success">
                Paid
            </div>
        @elseif (isset($interpretation->contractorInterpretation) &&
                $interpretation->contractorInterpretation->is_accepted == 2 &&
                $interpretation->interpreter_id == null)
            <div class="w-full btn btn-warning">
                Interpreter Declined
            </div>
        @endif
    @else
        {{-- Interpretation completed --}}
        @if ($interpretation->translation_status == \App\Enums\TranslationStatusEnum::COMPLETED)
            @if (
                $interpretation->orderStatus == 'Completed' &&
                    isset($interpretation->proofReaderOrder) &&
                    $interpretation->proofread_sent == 1)
                <div class="w-full btn btn-success">
                    WO Completed
                </div>
            @elseif(isset($interpretation->proofReaderOrder) &&
                    $interpretation->proofread_sent == 1 &&
                    $interpretation->orderStatus != 'Completed')
                <div class="w-full btn btn-success">
                    ProofRead Completed
                </div>
            @elseif ($interpretation->is_cancelled == 1)
                <div class="w-full btn btn-danger">
                    Cancelled
                </div>
            @else
                <div class="w-full">
                    -
                </div>
            @endif
        @endif
    @endif
@endif
