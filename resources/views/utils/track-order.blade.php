<div class="px-5 sm:px-20">
    @php
        $steps = [
            ['number' => 1, 'text' => 'Order Created', 'status' => 'success'],
            ['number' => 2, 'text' => 'Invoice Sent', 'status' => $order->invoiceSent == 1 || ($order->user->role_id == 1 || $order->user->role_id == 2) ? 'success' : ''],
            ['number' => 3, 'text' => 'Payment Paid', 'status' => $order->paymentStatus == 2 || $order->paymentStatus == 1 ? 'success' : ''],
            ['number' => 4, 'text' => 'Translator Assigned', 'status' => $order->invoiceSent == 1 && ($order->paymentStatus == 2 || $order->paymentStatus == 1) && $order->translation_status == 1 && $order->translation_sent == 1 ? 'success' : ''],
            [
                'number' => 5,
                'text' => 'Proof Reader Assigned',
                'status' => ($order->invoiceSent == 1 && ($order->paymentStatus == 2 || $order->paymentStatus == 1) && $order->translation_status == 1 && $order->proofread_status) == 1 ? 'success' : '',
            ],
            ['number' => 6, 'text' => 'Order Completed', 'status' => $order->translation_status == 1 && $order->orderStatus == 'Completed' ? 'success' : ''],
        ];
    @endphp
    @php
        $prevStatus = '';
        $tempSteps = $steps;
        foreach ($steps as $index => $step) {
            if ($step['status'] == 'success') {
                $prevStatus = 'success';
            } elseif ($prevStatus == 'success' && $step['status'] == '') {
                $step['status'] = 'warning';
                $tempSteps[$index]['status'] = 'warning';
                $prevStatus = 'warning';
            } else {
                $prevStatus = '';
            }
        }
    @endphp

    @foreach ($tempSteps as $index => $step)
        {{-- @if ($step['status'] == 'success' && isset($steps[$index + 1]))
            @php
                // $nextIndex = $index + 1;
                $steps['status'] = 'warning';
            @endphp
        @endif --}}
        <div class="intro-x flex items-center mt-5">
            <button
                class="w-10 h-10 rounded-full btn 
            @if ($step['status'] == 'success') btn-success
            @elseif ($step['status'] == 'warning')
                btn-warning
            @else
                text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400 @endif">
                {{ $step['number'] }}
            </button>
            <div
                class="text-base
            @if ($step['status'] == 'success' || $step['status'] == 'warning') text-slate-600 dark:text-slate-500 @endif ml-3">
                {{ $step['text'] }}
                <div>
                    @switch($step['number'])
                        {{-- Order Created  --}}
                        @case(1)
                            @if (isset($order->orderLogs) && count($order->orderLogs) > 0)
                                <hr>
                                <div class="row">
                                    @foreach ($order->orderLogs as $orderLog)
                                        @if ($orderLog->new_order_completed_status == 0)
                                            {{ $orderLog->created_at->format('y-m-d h:m:s') }} -
                                            @if ($orderLog->is_admin == 0)
                                                {{ $orderLog->user->name }} {{ $orderLog->action }}
                                            @else
                                                {{ $orderLog->admin->name }} {{ $orderLog->action }}
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @break

                        {{-- Invoice --}}
                        @case(2)
                            @if (isset($order->invoiceLogs) && count($order->invoiceLogs) > 0)
                                <hr>

                                @foreach ($order->invoiceLogs as $invoiceLog)
                                    <div class="row">
                                        {{ $invoiceLog->created_at->format('y-m-d h:m:s') }} -
                                        @if ($invoiceLog->is_admin == 0)
                                            {{ $invoiceLog->user->name }} {{ $invoiceLog->action }}
                                        @elseif($invoiceLog->is_admin == 1)
                                            {{ $invoiceLog->admin->name }} {{ $invoiceLog->action }}
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        @break

                        @case(3)
                        @break

                        {{-- Translator --}}
                        @case(4)
                            @if (isset($order->contractorLogs) && count($order->contractorLogs) > 0)
                                <hr>

                                @foreach ($order->contractorLogs as $contractorLog)
                                    <div class="row">
                                        {{ $contractorLog->created_at->format('y-m-d h:m:s') }} -
                                        @if ($contractorLog->is_admin == 1 && $contractorLog->contractor_type == 'Translator')
                                            {{-- @dd($contractorLog) --}}
                                            {{ $contractorLog->admin->name }} {{ $contractorLog->action }}
                                        @elseif ($contractorLog->is_admin == 0 && $contractorLog->contractor_type == 'Translator')
                                            {{ $contractorLog->action }}
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        @break

                        {{-- Proof Read --}}
                        @case(5)
                            @if (isset($order->contractorLogs) && count($order->contractorLogs) > 0)
                                <hr>

                                @foreach ($order->contractorLogs as $contractorLog)
                                    <div class="row">
                                        {{ $contractorLog->created_at->format('y-m-d h:m:s') }} -
                                        @if ($contractorLog->is_admin == 1 && $contractorLog->contractor_type == 'Proof Reader')
                                            {{-- @dd($contractorLog) --}}
                                            {{ $contractorLog->admin->name }} {{ $contractorLog->action }}
                                        @elseif ($contractorLog->is_admin == 0 && $contractorLog->contractor_type == 'Proof Reader')
                                            {{ $contractorLog->action }}
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        @break

                        {{-- Order Completed --}}
                        @case(6)
                            @if (isset($order->orderLogs) && count($order->orderLogs) > 0)
                                <hr>
                                <div class="row">
                                    @foreach ($order->orderLogs as $orderLog)
                                        @if ($orderLog->is_admin == 1 && $orderLog->new_order_completed_status == 1)
                                            {{ $orderLog->created_at->format('y-m-d h:m:s') }} -
                                            {{ $orderLog->admin->name }} {{ $orderLog->action }}
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @break

                        @default
                    @endswitch
                </div>
            </div>
        </div>
    @endforeach
</div>
