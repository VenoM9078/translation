@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

</div>
<!-- BEGIN: Data List -->
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            Interpretation Orders
        </h2>
    </div>

    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                    <div class="overflow-x-auto">
                        <table id="myTable" class="table table-striped hover mt-10" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">Work Number</th>
                                    <th class="whitespace-nowrap text-center">Language</th>
                                    <th class="whitespace-nowrap text-center">Interpretation Date</th>
                                    <th class="whitespace-nowrap text-center">Start Time</th>
                                    <th class="whitespace-nowrap text-center">End Time</th>
                                    <th class="whitespace-nowrap text-center">Session Format</th>
                                    <th class="whitespace-nowrap text-center">Interpreter Assigned</th>
                                    <th class="whitespace-nowrap text-center">Created At</th>
                                    <th class="whitespace-nowrap w-40">Status</th>
                                    <th class="whitespace-nowrap text-center">Possible Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($interpretations as $interpretation)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $interpretation->worknumber }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->language }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretationDate }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->start_time }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->end_time }}</td>

                                    <td class="whitespace-nowrap">{{ $interpretation->session_format }}</td>
                                    <td class="whitespace-nowrap">
                                        @if ($interpretation->interpreter_id === NULL)
                                        N/A
                                        @else
                                        {{ $interpretation->interpreter->name }}
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap">{{
                                        $interpretation->created_at->timezone('America/Los_Angeles') }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @if ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 &&
                                        $interpretation->paymentStatus == 0)

                                        <div class="progress h-4">
                                            <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100">0%</div>
                                        </div>

                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus == 0)

                                        <div class="progress h-4">
                                            <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="25"
                                                aria-valuemin="0" aria-valuemax="100">25%</div>
                                        </div>

                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id === NULL &&
                                        $interpretation->interpreter_completed == 0)

                                        <div class="progress h-4">
                                            <div class="progress-bar w-2/4 bg-primary" role="progressbar"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%
                                            </div>
                                        </div>

                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id !== NULL &&
                                        $interpretation->interpreter_completed == 0)

                                        <div class="progress h-4">
                                            <div class="progress-bar w-3/4 bg-pending" role="progressbar"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                                        </div>

                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id !== NULL &&
                                        $interpretation->interpreter_completed == 1)

                                        <div class="progress h-4">
                                            <div class="progress-bar w-full bg-success" role="progressbar"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                        </div>

                                        @elseif ($interpretation->wantQuote == 1)

                                        <div class="progress h-4">
                                            <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100">0%</div>
                                        </div>

                                        @elseif ($interpretation->wantQuote == 2 && $interpretation->paymentStatus == 0)
                                        <div class="progress h-4">
                                            <div class="progress-bar w-1/2 bg-warning" role="progressbar"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                                        </div>
                                        @elseif ($interpretation->wantQuote == 2 && $interpretation->paymentStatus == 1)
                                        <div class="progress h-4">
                                            <div class="progress-bar w-3/4 bg-primary" role="progressbar"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                                        </div>
                                        @elseif ($interpretation->wantQuote == 3 && $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id ===
                                        NULL && $interpretation->interpreter_completed == 0)
                                        <div class="progress h-4">
                                            <div class="progress-bar w-3/4 bg-primary" role="progressbar"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                                        </div>
                                        @elseif ($interpretation->wantQuote == 3 && $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id !==
                                        NULL && $interpretation->interpreter_completed == 0)
                                        <div class="progress h-4">
                                            <div class="progress-bar w-3/4 bg-pending" role="progressbar"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                                        </div>
                                        @elseif ($interpretation->wantQuote == 3 && $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id !==
                                        NULL && $interpretation->interpreter_completed == 1)
                                        <div class="progress h-4">
                                            <div class="progress-bar w-full bg-success" role="progressbar"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                        </div>
                                        @endif

                                    </td>

                                    <td class="whitespace-nowrap">
                                        @if ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 &&
                                        $interpretation->paymentStatus == 0)
                                        <a href="{{ route('admin.showSubmitQuote', $interpretation->id) }}"
                                            class="btn btn-warning mr-1 mb-2">Send Invoice</a>
                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus ==
                                        0)
                                        <button class="btn btn-warning mr-1 mb-2">Waiting for Payment <i
                                                data-loading-icon="three-dots" data-color="1a202c"
                                                class="w-4 h-4 ml-2"></i></button>
                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id === NULL &&
                                        $interpretation->interpreter_completed == 0)
                                        <button class="btn btn-warning mr-1 mb-2">Assign Interpreter</button>
                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id !== NULL &&
                                        $interpretation->interpreter_completed == 0)
                                        <button class="btn btn-warning mr-1 mb-2">Assign Interpreter</button>
                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id !== NULL &&
                                        $interpretation->interpreter_completed == 1)
                                        <button class="btn btn-warning mr-1 mb-2">View Feedback</button>
                                        @elseif ($interpretation->wantQuote == 1)
                                        <a href="{{ route('admin.showSubmitQuote', $interpretation->id) }}"
                                            class="btn btn-warning mr-1 mb-2">Submit Quote</a>
                                        @elseif ($interpretation->wantQuote == 2)
                                        <button class="btn btn-warning mr-1 mb-2">Waiting for Payment <i
                                                data-loading-icon="three-dots" data-color="1a202c"
                                                class="w-4 h-4 ml-2"></i></button>
                                        @elseif ($interpretation->wantQuote == 3 && $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id
                                        === NULL && $interpretation->interpreter_completed == 0)
                                        <button class="btn btn-warning mr-1 mb-2">Assign Interpreter</button>
                                        @elseif ($interpretation->wantQuote == 3 && $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id
                                        !== NULL && $interpretation->interpreter_completed == 0)
                                        <button class="btn btn-warning mr-1 mb-2">Assign Interpreter</button>
                                        @elseif ($interpretation->wantQuote == 3 && $interpretation->paymentStatus == 1
                                        && $interpretation->interpreter_id
                                        !== NULL && $interpretation->interpreter_completed == 1)
                                        <button class="btn btn-warning mr-1 mb-2">View Feedback</button>
                                        @endif
                                    </td>


                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>

        </div>
    </div>


</div>
<!-- END: Data List -->
<!-- END: Pagination -->
</div>
@endsection