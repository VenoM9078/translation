@extends('user.layout')
@section('content')
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                My Interpretation Orders
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
                                            <td class="whitespace-nowrap">{{ $interpretation->interpretationDate }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->start_time) }}
                                                -
                                                {{ App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->end_time) }}
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->language }}</td>
                                            {{-- Session Format --}}
                                            <td class="whitespace-nowrap">{{ $interpretation->session_format }}</td>
                                            {{-- Session Location --}}
                                            <td class="whitespace-nowrap">{{ $interpretation->location }}</td>
                                            {{-- Session Title --}}
                                            <td class="whitespace-nowrap">{{ $interpretation->session_topics }}</td>
                                            {{-- Quote --}}
                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#note-modal-preview{{ $interpretation->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>
                                            <!-- BEGIN: Modal Content -->
                                            <div id="note-modal-preview{{ $interpretation->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">Interpretation Note</div>
                                                                <div class="w-full text-left">
                                                                    <label for="order-form-21" class="form-label">Quote
                                                                        Message:</label>
                                                                    <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $interpretation->quote_description }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            <td class="whitespace-nowrap">{{ $interpretation->interpreter->name ?? '-' }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#message-modal-preview{{ $interpretation->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>
                                            <!-- BEGIN: Modal Content -->
                                            <div id="message-modal-preview{{ $interpretation->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">Interpretation Message</div>
                                                                <div class="w-full text-left">
                                                                    <label for="order-form-21" class="form-label">
                                                                        Message:</label>
                                                                    <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $interpretation->message }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->

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
                                                        class="btn btn-warning mr-1 mb-2">View Quote & Pay</a>
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

    <script>
        let button = document.querySelector('#uniqueModal');

        button.addEventListener('click', function() {
            let value = button.value;

            console.log(value);
        })
    </script>
@endsection
