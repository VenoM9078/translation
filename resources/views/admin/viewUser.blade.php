@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

</div>
<!-- BEGIN: User Info -->

<div class="intro-y col-span-12 mt-4">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Basic Information
            </h2>
        </div>
        <div id="vertical-form" class="p-5">
            <form>
                <div class="preview">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" required disabled
                            class="intro-x login__input form-control py-3 px-4 block mt-1" placeholder="Enter Name"
                            value="{{ $user->name }}">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="text" name="phonenumber" disabled
                            class="intro-x login__input form-control py-3 px-4 block mt-1"
                            placeholder="Enter Phone Number" value="{{ $user->email }}">
                    </div>


                    {{-- <a href="{{ route('admin.viewContractors') }}" class="btn btn-primary mt-5">Back</a> --}}
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END: User Info -->


<div class="intro-y col-span-12 mt-4">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Orders
            </h2>
        </div>
        <div id="vertical-form" class="p-5">
            <form>
                <div class="preview">
                    <table class="table table-striped hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">Work Number</th>
                                <th class="whitespace-nowrap">Access Code</th>
                                <th class="whitespace-nowrap">Current Language</th>
                                <th class="whitespace-nowrap">Translated Language</th>
                                <th class="whitespace-nowrap">Payment Status</th>
                                <th class="whitespace-nowrap">Order Status</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->orders as $order)
                            <tr>
                                <td class="whitespace-nowrap">{{ $order->worknumber }}</td>
                                <td class="whitespace-nowrap">{{ $order->access_code }}</td>
                                <td class="whitespace-nowrap">{{ $order->language1 }}</td>
                                <td class="whitespace-nowrap">{{ $order->language2 }}</td>
                                @if ($order->paymentStatus == 1)
                                <td class="whitespace-nowrap"><button
                                        class="btn btn-rounded-success w-24 mr-1 mb-2">Paid</button></td>
                                @elseif($order->paymentStatus == 2)
                                <td class="whitespace-nowrap"><button
                                        class="btn btn-rounded-warning w-28 mr-1 mb-2">Payment
                                        Later</button></td>
                                @elseif($order->paymentStatus == 3)
                                <td class="whitespace-nowrap"><button
                                        class="btn btn-rounded-warning w-32 mr-1 mb-2">Request
                                        Pending</button></td>
                                @else
                                <td class="whitespace-nowrap"><button
                                        class="btn btn-rounded-pending w-24 mr-1 mb-2">Pending</button></td>
                                @endif
                                <td class="whitespace-nowrap">
                                    @if ($order->invoiceSent == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">0%
                                        </div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 2)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">35%
                                        </div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 3)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">25%
                                        </div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0 &&
                                    $order->is_evidence == 1)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">35%
                                        </div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">25%
                                        </div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 &&
                                    $order->translation_status == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-2/4 bg-primary" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">50%
                                        </div>
                                    </div>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 1 &&
                                    $order->proofread_status == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-3/4 bg-pending" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">75%
                                        </div>
                                    </div>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 1 &&
                                    $order->proofread_status == 1)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-4/4 bg-success" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">100%
                                        </div>
                                    </div>
                                    @endif

                                </td>
                                <td class="whitespace-nowrap">{{ $order->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                    {{-- <a href="{{ route('admin.viewContractors') }}" class="btn btn-primary mt-5">Back</a> --}}
                </div>
            </form>
        </div>
    </div>
</div>


<div class="intro-y col-span-12 mt-4">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Interpretations
            </h2>
        </div>
        <div id="vertical-form" class="p-5">
            <form>
                <div class="preview">
                    <table class="table table-striped hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">Work Number</th>
                                <th class="whitespace-nowrap">Language</th>
                                <th class="whitespace-nowrap">Interpretation Date</th>
                                <th class="whitespace-nowrap">Start Time</th>
                                <th class="whitespace-nowrap">End Time</th>
                                <th class="whitespace-nowrap">Session Format</th>
                                <th class="whitespace-nowrap">Created At</th>
                                <th class="whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->interpretations as $interpretation)
                            <tr>
                                <td class="whitespace-nowrap">{{ $interpretation->worknumber }}</td>
                                <td class="whitespace-nowrap">{{ $interpretation->language }}</td>
                                <td class="whitespace-nowrap">{{ $interpretation->interpretationDate }}</td>
                                <td class="whitespace-nowrap">{{ $interpretation->start_time }}</td>
                                <td class="whitespace-nowrap">{{ $interpretation->end_time }}</td>
                                <td class="whitespace-nowrap">{{ $interpretation->session_format }}</td>


                                <td class="whitespace-nowrap">{{
                                    $interpretation->created_at->timezone('America/Los_Angeles') }}
                                </td>
                                <td class="whitespace-nowrap">
                                    @if ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 &&
                                    $interpretation->paymentStatus == 0)
                                    Payment Required
                                    @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                    $interpretation->paymentStatus == 0)
                                    Waiting for Payment
                                    @elseif ($interpretation->wantQuote == 3 && $interpretation->invoiceSent == 1 &&
                                    $interpretation->paymentStatus == 1
                                    && $interpretation->interpreter_id === NULL &&
                                    $interpretation->interpreter_completed == 0)
                                    Payment Confirmed
                                    @elseif ($interpretation->wantQuote == 3 && $interpretation->invoiceSent == 1 &&
                                    $interpretation->paymentStatus == 1
                                    && $interpretation->interpreter_id !== NULL &&
                                    $interpretation->interpreter_completed == 0)
                                    Interpreter Confirmed
                                    @elseif ($interpretation->wantQuote == 3 && $interpretation->invoiceSent == 1 &&
                                    $interpretation->paymentStatus == 1
                                    && $interpretation->interpreter_id !== NULL &&
                                    $interpretation->interpreter_completed == 1)
                                    Interpretation Completed
                                    @elseif ($interpretation->wantQuote == 1)
                                    Quote Requested
                                    @elseif ($interpretation->wantQuote == 2)
                                    Quote Ready
                                    @elseif ($interpretation->wantQuote == 3 && $interpretation->paymentStatus == 1
                                    && $interpretation->interpreter_id
                                    === NULL && $interpretation->interpreter_completed == 0)
                                    Payment Confirmed
                                    @elseif ($interpretation->wantQuote == 3 && $interpretation->paymentStatus == 1
                                    && $interpretation->interpreter_id
                                    !== NULL && $interpretation->interpreter_completed == 0)
                                    Interpreter Confirmed
                                    @elseif ($interpretation->wantQuote == 3 && $interpretation->paymentStatus == 1
                                    && $interpretation->interpreter_id
                                    !== NULL && $interpretation->interpreter_completed == 1)
                                    Interpretation Completed
                                    @endif
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </form>
        </div>
    </div>
</div>
<a href="{{ route('admin.viewCustomers') }}" class="btn btn-primary mt-5">Back</a>
@endsection