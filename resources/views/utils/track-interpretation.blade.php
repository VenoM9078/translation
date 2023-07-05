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
        
        // foreach ($steps as $index => $step) {
        //     if ($step['status'] == 'success') {
        //         $prevStatus = 'success';
        //     } elseif ($prevStatus == 'success' && $step['status'] == '') {
        //         $step['status'] = 'warning';
        //         $tempSteps[$index]['status'] = 'warning';
        //         $prevStatus = 'warning';
        //     } else {
        //         $prevStatus = '';
        //     }
        // }
        // Combine logs
        $logsQuery1 = App\Models\OrderLog::query()
            ->with(['user', 'admin'])
            ->where('interpretation_id', $interpretation->id)
            ->select('created_at', 'action', 'is_admin', 'user_id', DB::raw("'interpretation' as log_type"), DB::raw('NULL as contractor_id'));
        
        $logsQuery2 = App\Models\InvoiceLogs::query()
            ->with(['user', 'admin'])
            ->where('interpretation_id', $interpretation->id)
            ->select('created_at', 'action', 'is_admin', 'user_id', DB::raw("'invoice' as log_type"), DB::raw('NULL as contractor_id'));
        
        $logsQuery3 = App\Models\ContractorLog::query()
            ->with(['contractor', 'admin'])
            ->where('interpretation_id', $interpretation->id)
            ->select('created_at', 'action', 'is_admin', 'user_id', DB::raw("'contractor' as log_type"), 'contractor_id');
        
        $logsQuery = $logsQuery1->unionAll($logsQuery2)->unionAll($logsQuery3);
        
        $logs = DB::query()
            ->fromSub($logsQuery, 'sub')
            ->orderBy('created_at', 'asc')
            ->get();
    @endphp
    @forelse ($logs as $log)
        <div class="intro-x flex items-center justify-center mt-5 bg-gray-100 p-5 rounded-lg">
            <div class="flex items-center justify-center">
                <span class="text-gray-900 font-semibold text-sm" style="font-size: 11px">
                    {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($log->created_at, request()->ip()) }} |
                </span>
                @php
                    $name = '';
                @endphp
                @if ($log->log_type === 'interpretation')
                    @if ($log->is_admin == 0)
                        @php
                            $user = App\Models\User::find($log->user_id);
                            $name = $user ? $user->name : '';
                        @endphp
                    @elseif($log->is_admin == 1)
                        @php
                            $admin = App\Models\Admin::find($log->user_id);
                            $name = $admin ? $admin->name : '';
                        @endphp
                    @endif
                @elseif ($log->log_type === 'invoice')
                    @if ($log->is_admin == 0)
                        @php
                            $user = App\Models\User::find($log->user_id);
                            $name = $user ? $user->name : '';
                        @endphp
                    @elseif($log->is_admin == 1)
                        @php
                            $admin = App\Models\Admin::find($log->user_id);
                            $name = $admin ? $admin->name : '';
                        @endphp
                    @endif
                @elseif ($log->log_type === 'contractor')
                    @if ($log->is_admin == 1)
                        @php
                            $admin = App\Models\Admin::find($log->user_id);
                            $name = $admin ? $admin->name : '';
                        @endphp
                    @elseif ($log->is_admin == 0 && $log->contractor_id)
                        @php
                            $contractor = App\Models\Contractor::find($log->contractor_id);
                            $name = $contractor ? $contractor->name : '';
                        @endphp
                    @endif
                @endif
                <span class="ml-2 text-blue-500 font-semibold hover:bg-slate-300" style="font-size: 12px">
                    {{ $name }} {{ $log->action }}
                </span>
                <br>
            </div>
        </div>
    @empty
        <div class="intro-x text-center mt-5">
            <div class="p-5" style="background-color: #f9f9f9">
                <span class="font-medium text-gray-600">
                    No Logs Tracked
                </span>
            </div>
        </div>
    @endforelse
</div>
