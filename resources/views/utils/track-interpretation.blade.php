<div class="px-5 sm:px-20">
    @php
        $steps = [
            ['number' => 0, 'text' => 'Created Interpretation', 'status' => $interpretation->interpretation_completed == 0 ? 'success' : ''],
            [
                'number' => 1,
                'text' => 'Invoice Sent',
                'status' => $interpretation->invoiceSent == 1 || ($interpretation->user->role_id == 1 || $interpretation->user->role_id == 2) ? 'success' : '',
            ],
            ['number' => 2, 'text' => 'Payment Paid', 'status' => $interpretation->paymentStatus == 2 || $interpretation->paymentStatus == 1 ? 'success' : ''],
            ['number' => 3, 'text' => 'Interpreter Assigned', 'status' => $interpretation->invoiceSent == 1 && ($interpretation->paymentStatus == 2 || $interpretation->paymentStatus == 1) && $interpretation->interpreter_id != null ? 'success' : ''],
            ['number' => 4, 'text' => 'Interpretation Completed', 'status' => $interpretation->interpreter_completed == 1 ? 'success' : ''],
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

    {{-- @dd($steps) --}}
    @foreach ($tempSteps as $index => $step)
        {{-- @if ($step['status'] == 'success' && isset($steps[$index + 1]))
            @php
                // $nextIndex = $index + 1;
                $steps['status'] = 'warning';
            @endphp
        @endif --}}
        {{-- @dd($tempSteps) --}}
        <div class="intro-x flex items-center mt-5">
            {{-- <button --}}
            {{-- class="w-10 h-10 rounded-full btn  --}}
            {{-- @if ($step['status'] == 'success') btn-success --}}
            {{-- @elseif ($step['status'] == 'warning') --}}
            {{-- btn-warning --}}
            {{-- @else --}}
            {{-- text-slate-500 bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400 @endif"> --}}
            {{-- {{ $step['number'] }} --}}
            {{-- </button> --}}
            <div class="text-base @if ($step['status'] == 'success' || $step['status'] == 'warning') text-slate-600 dark:text-slate-500 @endif ml-3">
                {{-- {{ $step['text'] }} --}}
                @if (isset($interpretation->interpretationLogs) && count($interpretation->interpretationLogs) < 1 && count($interpretation->contractorLogs) < 1 && count($interpretation->invoiceLogs) < 1 && count($interpretation->interpretationLogs) < 1)
                    <div class="row text-center mx-auto">
                        <h2>No Log Tracked For Interpretation.</h2>
                    </div>
                @break

            @else
                <div>
                    @switch($step['number'])
                        @case(0)
                            <div class="row">
                                @if (isset($interpretation->interpretationLogs) && count($interpretation->interpretationLogs) > 0)
                                    @foreach ($interpretation->interpretationLogs as $orderLog)
                                        @if ($orderLog->interpretation_status == 0 && $orderLog->is_interpretation == 1)
                                            @if ($orderLog->is_admin == 0 && ($orderLog->action != \App\Enums\LogActionsEnum::PAYMENTCOMPLETED))
                                                {{ $orderLog->created_at }} -
                                                {{ $orderLog->user->name }} {{ $orderLog->action }}
                                                <br>
                                            @elseif($orderLog->is_admin == 1)
                                                @if (
                                                    $orderLog->action != \App\Enums\LogActionsEnum::INVOICESENT &&
                                                        $orderLog->action != \App\Enums\LogActionsEnum::PAYMENTCOMPLETED)
                                                    {{ $orderLog->created_at }} -
                                                    {{ $orderLog->admin->name }} {{ $orderLog->action }}
                                                    <br>
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                @else
                                   
                                @endif
                            </div>
                        @break

                        {{-- Invoice --}}
                        @case(1)
                            @if (isset($interpretation->invoiceLogs) && count($interpretation->invoiceLogs) > 0)
                                @foreach ($interpretation->invoiceLogs as $invoiceLog)
                                    <div class="row">
                                        @if ($invoiceLog->is_admin == 0)
                                            {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($invoiceLog->created_at, request()->ip()) }}
                                            -
                                            {{ $invoiceLog->user->name ?? '-' }} {{ $invoiceLog->action }}
                                            <br>
                                        @elseif($invoiceLog->is_admin == 1)
                                            @if ($invoiceLog->action != \App\Enums\LogActionsEnum::INVOICESENT)
                                                {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($invoiceLog->created_at, request()->ip()) }}
                                                -
                                                {{ $invoiceLog->admin->name ?? '-' }} {{ $invoiceLog->action }}
                                            @endif
                                            <br>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        @break

                        {{-- Payment --}}
                        @case(2)
                            @foreach ($interpretation->interpretationLogs as $orderLog)
                                @if (
                                    $orderLog->is_admin == 0 &&
                                        $orderLog->interpretation_status == 0 &&
                                        $orderLog->is_interpretation == 1 &&
                                        $orderLog->new_payment_status == 1)
                                    @if ($orderLog->is_admin == 0)
                                        {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($orderLog->created_at, request()->ip()) }}
                                        -
                                        {{ $orderLog->user->name }} {{ $orderLog->action }}
                                        <br>
                                        {{-- @elseif($orderLog->is_admin == 1) --}}
                                        {{-- {{ $orderLog->created_at->format('y-m-d H:M:S') }} - --}}
                                        {{-- {{ $orderLog->admin->name }} {{ $orderLog->action }} --}}
                                        {{-- <br> --}}
                                    @endif
                                @endif
                            @endforeach
                        @break

                        {{-- Translator --}}
                        @case(3)
                            @if (isset($interpretation->contractorLogs) && count($interpretation->contractorLogs) > 0)
                                @foreach ($interpretation->contractorLogs as $contractorLog)
                                    <div class="row">
                                        @if ($contractorLog->is_admin == 1 && $contractorLog->contractor_type == 'Interpreter')
                                            {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($contractorLog->created_at, request()->ip()) }}
                                            -
                                            {{ $contractorLog->admin->name ?? '-' }} {{ $contractorLog->action }}
                                            <br>
                                        @elseif ($contractorLog->is_admin == 0 && $contractorLog->contractor_type == 'Interpreter')
                                            {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($contractorLog->created_at, request()->ip()) }}
                                            -
                                            {{ $contractorLog->contractor->name }} {{ $contractorLog->action }}
                                            <br>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        @break

                        @case(4)
                            {{-- Completed --}}
                            @foreach ($interpretation->interpretationLogs as $orderLog)
                                @if ($orderLog->interpretation_status == 1 && $orderLog->is_interpretation == 1)
                                    @if ($orderLog->is_admin == 0)
                                        {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($orderLog->created_at, request()->ip()) }}
                                        -
                                        {{ $orderLog->user->name }} {{ $orderLog->action }}
                                        <br>
                                    @elseif($orderLog->is_admin == 1)
                                        {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($orderLog->created_at, request()->ip()) }}
                                        -
                                        {{ $orderLog->admin->name }} {{ $orderLog->action }}
                                        <br>
                                    @endif
                                @endif
                            @endforeach
                        @break

                        @default
                    @endswitch
                </div>
            @endif
        </div>
    </div>
@endforeach
</div>
