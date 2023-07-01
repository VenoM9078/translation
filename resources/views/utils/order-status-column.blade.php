@if (Auth::user()->getTable() != 'admins')
    {{-- Status for Users --}}
    @if ($order->want_quote == 0 && $order->translation_status == 0)
        <div class="w-full btn btn-warning">
            Translation Requested
        </div>
    @elseif ($order->want_quote == 1)
        <div class="w-full btn btn-warning">
            Quote Requested
        </div>
    @elseif($order->want_quote == 2)
        <div class="w-full btn btn-success">
            Quote Ready
        </div>
    @elseif (isset($order->contractorOrder) && $order->contractorOrder->is_accepted == 1 && $order->translation_status == 0)
        <div class="w-full btn btn-warning">
            Translation In Progress
        </div>
    @elseif ($order->translation_status == \App\Enums\TranslationStatusEnum::COMPLETED)
        <div class="w-full btn btn-success">
            Translation Completed
        </div>
    @elseif ($order->orderStatus == 'Cancelled')
        <div class="w-full btn btn-danger">
            Cancelled
        </div>
    @else
        <div class="w-full">
            -
        </div>
    @endif
@else
    {{-- Status for FT Admin --}}
    {{--
         want_quote 
          0 -> no
         1 -> yes
         2 -> sent  
        --}}
    {{-- Translation pending/not completed --}}
    @if ($order->translation_status == 0)
        @if (
            $order->want_quote == 0 &&
                ($order->user->role_id == 1 || $order->user->role_id == 2) &&
                !isset($order->contractorOrder))
            <div class="w-full btn btn-warning">
                Translation Requested
            </div>
        @elseif ($order->want_quote == 1 && !isset($order->contractorOrder))
            {{--   
         "Quote Requested" is set, if a new order is submitted with requesting a quote.
     --}}
            <div class="w-full btn btn-warning">
                Quote Requested
            </div>
        @elseif(
            $order->want_quote == 2 &&
                $order->is_order_quote_accepted == \App\Enums\OrderStatusEnum::QUOTEACCEPTED &&
                !isset($order->contractorOrder))
            {{-- 
                " Approved" is set, when client approve the quote. 
            --}}
            <div class="w-full btn btn-success">
                Quote Approved
            </div>
        @elseif($order->want_quote == 1)
            {{-- 
            "Quote Ready" is set, if FT admin uploads a quote  (or generates quotes with a template form - TBD) to website. 
            --}}
            <div class="w-full btn btn-success">
                Quote Ready
            </div>
        @elseif($order->paymentStatus == 0 && $order->want_quote == 0)
            {{-- 
            "Payment Required" is set, if a new order is submitted without requesting a quote by individual user.  
        --}}
            <div class="w-full btn btn-warning">
                Payment Required
            </div>
        @elseif(
            ($order->paymentStatus == 1 || $order->paymentStatus == 2) &&
                $order->translation_status == 0 &&
                !isset($order->contractorOrder))
            <div class="w-full btn btn-success">
                Paid
            </div>
        @elseif (isset($order->contractorOrder) && $order->contractorOrder->is_accepted == 0 && $order->translation_status == 0)
            {{-- 
        "Translater Assigned" is set, when FT admin assigns translator (and proofreader) by using "Assign" button
    --}}
            <div class="w-full btn btn-warning">
                Translator Assigned
            </div>
        @elseif (isset($order->contractorOrder) && $order->contractorOrder->is_accepted == 1 && $order->translation_status == 0)
            <div class="w-full btn btn-success">
                Translation Comfirmed
            </div>
        @elseif (isset($order->contractorOrder) && $order->contractorOrder->is_accepted == 2 && $order->translation_status == 0)
            <div class="w-full btn btn-warning">
                Translation Declined
            </div>
        @elseif(isset($order->proofReaderOrder) && $order->proofReaderOrder->is_accepted == 2)
            <div class="w-full btn btn-warning">
                Proof Reader Declined
            </div>
        @elseif(isset($order->proofReaderOrder) &&
                $order->proofReaderOrder->is_accepted == 1 &&
                $order->proofReaderOrder->translation_status == 0)
            <div class="w-full btn btn-success">
                Proof Reader Accepted
            </div>
        @elseif(isset($order->proofReaderOrder) &&
                $order->proofReaderOrder->is_accepted == 1 &&
                $order->proofread_status == \App\Enums\TranslationStatusEnum::COMPLETED &&
                $order->proofReaderOrder->file_name != null)
            <div class="w-full btn btn-success">
                ProofRead Completed
            </div>
        @endif
    @else
        {{-- Translation completed --}}
        @if ($order->translation_status == \App\Enums\TranslationStatusEnum::COMPLETED)
            @if ($order->orderStatus == 'Completed' && isset($order->proofReaderOrder) && $order->proofread_sent == 1)
                <div class="w-full btn btn-success">
                    WO Completed
                </div>
            @elseif(isset($order->proofReaderOrder) && $order->proofread_sent == 1 && $order->orderStatus != 'Completed')
                <div class="w-full btn btn-success">
                    ProofRead Completed
                </div>
            @elseif ($order->orderStatus == 'Cancelled')
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
