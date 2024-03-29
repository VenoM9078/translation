@extends('user.layout')

@section('content')
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                Institute - Interpretations
            </h2>
        </div>

        <div class="intro-y box">
            <div id="vertical-form" class="p-5">
                <div class="preview">
                    <div>
                        <div class="overflow-x-auto">
                            <table id="myTable" class="table table-striped hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">WO#</th>
                                        <th class="whitespace-nowrap">Requester</th>
                                        <th class="whitespace-nowrap">Session Date</th>
                                        <th class="whitespace-nowrap">Scheduled Time</th>
                                        <th class="whitespace-nowrap">Language</th>
                                        <th class="whitespace-nowrap">Session Format</th>
                                        <th class="whitespace-nowrap">Session Location</th>
                                        <th class="whitespace-nowrap">Session Title</th>
                                        <th class="whitespace-nowrap">Quote</th>
                                        <th class="whitespace-nowrap">Interpreter</th>
                                        <th class="whitespace-nowrap">Message</th>
                                        <th class="whitespace-nowrap">Created At</th>
                                        <th class="whitespace-nowrap">Status</th>
                                        <th class="whitespace-nowrap">Possible Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($interpretations as $interpretation)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $interpretation->worknumber }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->user->name }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->interpretationDate }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->start_time, request()->ip()) }} -{{
                                                    App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->end_time, request()->ip()) }}
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->language }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->session_format }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->location }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->session_topics }}</td>
                                            <td title="{{ $interpretation->quote_description }}"><i
                                                    data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->interpreter->name ?? '-' }}</td>
                                            <td title="{{ $interpretation->message }}"><i
                                                    data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                            </td>
                                            <td class="whitespace-nowrap">
                                                {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($interpretation->created_at, request()->ip()) }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if (
                                                    $interpretation->added_by_institute_user == 1 &&
                                                        $interpretation->interpreter_id === null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    Waiting for Interpreter
                                                @elseif (
                                                    $interpretation->added_by_institute_user == 1 &&
                                                        $interpretation->interpreter_id != null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    Interpreter Confirmed
                                                @elseif (
                                                    $interpretation->added_by_institute_user == 1 &&
                                                        $interpretation->interpreter_id != null &&
                                                        $interpretation->interpreter_completed == 1)
                                                    Interpretation Completed
                                                @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 && $interpretation->paymentStatus == 0)
                                                    Payment Required
                                                @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 && $interpretation->paymentStatus == 0)
                                                    Waiting for Payment
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->invoiceSent == 1 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id === null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    Payment Confirmed
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->invoiceSent == 1 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    Interpreter Confirmed
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->invoiceSent == 1 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 1)
                                                    Interpretation Completed
                                                @elseif ($interpretation->wantQuote == 1)
                                                    Quote Requested
                                                @elseif ($interpretation->wantQuote == 2)
                                                    Quote Ready
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id === null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    Payment Confirmed
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    Interpreter Confirmed
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 1)
                                                    Interpretation Completed
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if (
                                                    $interpretation->added_by_institute_user == 1 &&
                                                        $interpretation->interpreter_id === null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    <button class="btn btn-success mr-1 mb-2">Waiting for Interpreter <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i></button>
                                                @elseif (
                                                    $interpretation->added_by_institute_user == 1 &&
                                                        $interpretation->interpreter_id != null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    <button class="btn btn-success mr-1 mb-2">Waiting for Interpretation <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i></button>
                                                @elseif (
                                                    $interpretation->added_by_institute_user == 1 &&
                                                        $interpretation->interpreter_id != null &&
                                                        $interpretation->interpreter_completed == 1)
                                                    <button class="btn btn-success mr-1 mb-2">Interpretation
                                                        Completed</button>
                                                @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 && $interpretation->paymentStatus == 0)
                                                    <button class="btn btn-warning mr-1 mb-2">Waiting for Invoice <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i></button>
                                                @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 && $interpretation->paymentStatus == 0)
                                                    <button class="btn btn-warning mr-1 mb-2">View Invoice</button>
                                                @elseif (
                                                    $interpretation->wantQuote == 2 &&
                                                        $interpretation->invoiceSent == 1 &&
                                                        $interpretation->paymentStatus == 0 &&
                                                        $interpretation->interpreter_id === null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    <button class="btn btn-success mr-1 mb-2">Waiting for Payment <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i></button>
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->invoiceSent == 1 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id == null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    <button class="btn btn-success mr-1 mb-2">Waiting for Interpreter <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i></button>
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->invoiceSent == 1 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    <button class="btn btn-success mr-1 mb-2">Waiting for Interpretation <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i></button>
                                                @elseif (
                                                    $interpretation->wantQuote == 0 &&
                                                        $interpretation->invoiceSent == 1 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 1)
                                                    <button class="btn btn-success mr-1 mb-2">Interpretation
                                                        Completed</button>
                                                @elseif ($interpretation->wantQuote == 1)
                                                    <button class="btn btn-warning mr-1 mb-2">Waiting for Quote <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i></button>
                                                @elseif ($interpretation->wantQuote == 2)
                                                    <a href="{{ route('viewQuoteInvoice', $interpretation->id) }}"
                                                        class="btn btn-warning mr-1 mb-2">View Quote
                                                        & Pay</a>
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    <button class="btn btn-success mr-1 mb-2">Waiting for Interpretation <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i></button>
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 1)
                                                    <button class="btn btn-warning mr-1 mb-2">Submit Feedback</button>
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
@endsection
