<div class="px-5 sm:px-20">
    @php
        $steps = [
            ['number' => 1, 
            'text' => 'Invoice Sent', 
            'status' => ($interpretation->invoiceSent == 1 || ($interpretation->user->role_id == 1 || $interpretation->user->role_id == 2)) ? 'success' : ''
            ], 
            ['number' => 2, 
            'text' => 'Payment Paid', 
            'status' => ($interpretation->paymentStatus == 2 || $interpretation->paymentStatus == 1)  ? 'success' : ''
            ], 
            ['number' => 3, 'text' => 'Interpreter Assigned', 'status' => 
            ($interpretation->invoiceSent == 1 && (($interpretation->paymentStatus == 2 || $interpretation->paymentStatus == 1)) && ($interpretation->interpreter_id != null))  ? 'success' : ''],
            ['number' => 4, 'text' => 'Interpretation Completed', 'status' =>  $interpretation->interpreter_completed == 1 ? 'success' : '']
        ];
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
