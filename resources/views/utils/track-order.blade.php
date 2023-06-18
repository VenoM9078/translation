<div class="px-5 sm:px-20">
    @php
        $steps = [
        ['number' => 1, 
        'text' => 'Invoice Sent', 
        'status' => ($order->invoiceSent == 1 || ($order->user->role_id == 1 || $order->user->role_id == 2)) ? 'success' : ''
        ], 
        ['number' => 2, 
        'text' => 'Payment Paid', 
        'status' => ($order->paymentStatus == 2 || $order->paymentStatus == 1)  ? 'success' : ''
        ], 
        ['number' => 3, 'text' => 'Translator Assigned', 'status' => 
        ($order->invoiceSent == 1 && (($order->paymentStatus == 2 || $order->paymentStatus == 1)) && $order->translation_status == 1 && $order->translation_sent == 1) ? 'success' : ''], 
        [
        'number' => 4, 'text' => 'Proof Reader Assigned', 
        'status' =>   
        ($order->invoiceSent == 1 && (($order->paymentStatus == 2 || $order->paymentStatus == 1)) && $order->translation_status == 1 && $order->proofread_status) == 1 ? 'success' : ''
        ], 
        ['number' => 5, 'text' => 'Order Completed', 'status' =>  $order->translation_status == 2 ? 'success' : '']];
    @endphp
    @php
        $prevStatus = '';
        foreach ($steps as $index => &$step) {
            if ($step['status'] == 'success') {
                $prevStatus = 'success';
            } elseif ($prevStatus == 'success' && $step['status'] == '') {
                $step['status'] = 'warning';
                $prevStatus = 'warning';
            } else {
                $prevStatus = '';
            }
        }
    @endphp

@foreach ($steps as $index => &$step)
    @if ($step['status'] == 'success' && isset($steps[$index + 1]))
        @php
            // $nextIndex = $index + 1;
            $steps['status'] = 'warning';
        @endphp
    @endif
    <div class="intro-x flex items-center mt-5">
        <button class="w-10 h-10 rounded-full btn 
            @if ($step['status'] == 'success')
                btn-success
            @elseif ($step['status'] == 'warning')
                btn-warning
            @else
                text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400
            @endif">
            {{ $step['number'] }}
        </button>
        <div class="text-base
            @if ($step['status'] == 'success' || $step['status'] == 'warning')
                text-slate-600 dark:text-slate-500
            @endif ml-3">
            {{ $step['text'] }}
        </div>
    </div>
    @endforeach
</div>
