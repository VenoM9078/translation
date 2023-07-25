<div class="">
    @php
        $steps = [
            ['number' => 1, 'text' => 'Order Created', 'status' => 'success'],
            ['number' => 2, 'text' => 'Invoice Sent', 'status' => $order->invoiceSent == 1 || ($order->user->role_id == 1 || $order->user->role_id == 2) ? 'success' : ''],
            ['number' => 3, 'text' => 'Payment Paid', 'status' => $order->paymentStatus == 2 || $order->paymentStatus == 1 ? 'success' : ''],
            ['number' => 4, 'text' => 'Translator Assigned', 'status' => $order->invoiceSent == 1 && ($order->paymentStatus == 2 || $order->paymentStatus == 1) && $order->translation_status == 1 && $order->translation_sent == 1 ? 'success' : ''],
            [
                'number' => 5,
                'text' => 'Proof Reader Assigned',
                'status' => $order->invoiceSent == 1 && ($order->paymentStatus == 2 || $order->paymentStatus == 1) && $order->proofread_status == 1 ? 'success' : '',
            ],
            ['number' => 6, 'text' => 'Order Completed', 'status' => $order->translation_status == 1 && $order->orderStatus == 'Completed' ? 'success' : ''],
        ];
    @endphp
    @php
        $prevStatus = '';
        $tempSteps = $steps;
        $showAction = false;
        $logsQuery1 = App\Models\OrderLog::query()
            ->with(['user', 'admin'])
            ->where('order_id', $order->id)
            ->select('created_at', 'action', 'is_admin', 'user_id', 'new_order_completed_status', 'new_payment_status', DB::raw("'order' as log_type"), DB::raw('NULL as contractor_id'), DB::raw('NULL as invoice_sent'));
        
        $logsQuery2 = App\Models\InvoiceLogs::query()
            ->with(['user', 'admin'])
            ->where('order_id', $order->id)
            ->select('created_at', 'action', 'is_admin', 'user_id', DB::raw('NULL as new_order_completed_status'), DB::raw('NULL as new_payment_status'), DB::raw("'invoice' as log_type"), DB::raw('NULL as contractor_id'), 'invoice_sent');
        
        $logsQuery3 = App\Models\ContractorLog::query()
            ->with(['contractor', 'admin'])
            ->where('order_id', $order->id)
            ->select('created_at', 'action', 'is_admin', 'user_id', DB::raw('NULL as new_order_completed_status'), DB::raw('NULL as new_payment_status'), DB::raw("'contractor' as log_type"), 'contractor_id', DB::raw('NULL as invoice_sent'));
        
        $logsQuery = $logsQuery1->unionAll($logsQuery2)->unionAll($logsQuery3);
        
        $logs = DB::query()
            ->fromSub($logsQuery, 'sub')
            ->orderBy('created_at', 'asc')
            ->get();
        $tempSteps = $logs;
    @endphp

    @forelse ($logs as $log)
        @if (
            ($log->is_admin == 1 &&
                $log->action != \App\Enums\LogActionsEnum::PAYMENTCOMPLETED &&
                $log->is_admin == 1 &&
                $log->action != \App\Enums\LogActionsEnum::INVOICESENT)
                || $log->is_admin == 0
                )
            <div class="intro-x flex items-center justify-center mt-5 bg-gray-100 p-5 rounded-lg">
                <div class="row flex items-center justify-center">
                    <span class="text-gray-900 font-semibold text-sm" style="font-size: 11px">
                        {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($log->created_at, request()->ip()) }} |
                    </span>

                    @php
                        $name = '';
                    @endphp
                    @if ($log->log_type === 'order')
                        @if ($log->new_order_completed_status == 0)
                            @if ($log->is_admin == 0 && $log->action != \App\Enums\LogActionsEnum::PAYMENTCOMPLETED)
                                @php
                                    $user = App\Models\User::find($log->user_id);
                                    $name = $user ? $user->name : '';
                                    $showAction = true;
                                @endphp
                            @elseif($log->is_admin == 1 && $log->action != \App\Enums\LogActionsEnum::PAYMENTCOMPLETED)
                                @php
                                    $admin = App\Models\Admin::find($log->user_id);
                                    $name = $admin ? $admin->name : '';
                                    $showAction = true;
                                @endphp
                            @endif
                        @endif
                    @elseif ($log->log_type === 'invoice')
                        @if ($log->is_admin == 0)
                            @php
                                $user = App\Models\User::find($log->user_id);
                                $name = $user ? $user->name : '';
                                $showAction = true;
                            @endphp
                        @elseif($log->is_admin == 1)
                            @php
                                $admin = App\Models\Admin::find($log->user_id);
                                $name = $admin ? $admin->name : '';
                                $showAction = true;
                            @endphp
                        @endif
                    @elseif ($log->log_type === 'contractor')
                        @if ($log->is_admin == 1)
                            @php
                                $admin = App\Models\Admin::find($log->user_id);
                                $name = $admin ? $admin->name : '';
                                $showAction = true;
                            @endphp
                        @elseif ($log->is_admin == 0)
                            @php
                                $contractor = App\Models\Contractor::find($log->contractor_id);
                                $name = $contractor ? $contractor->name : '';
                                $showAction = true;
                            @endphp
                        @endif
                    @endif

                    @if($showAction == true)
                    <span class="ml-2 text-blue-500 font-semibold hover:bg-slate-300" style="font-size: 12px">
                        {{ $name }} {{ $log->action }}
                    </span>
                    @endif
                    <br>
                </div>
            </div>
        @endif
    @empty
        <div class="intro-x flex items-center justify-center mt-5 bg-gray-100 p-5 rounded-lg">
            <span>No Logs Tracked</span>
        </div>
    @endempty
</div>
