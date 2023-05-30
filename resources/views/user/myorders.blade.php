@extends('user.layout')

@section('content')
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            My Translation Orders
        </h2>
    </div>

    @if ($message = Session::get('message'))
    <div class="alert alert-success mt-3">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                    <div class="overflow-x-auto">
                        <table id="myTable" class="table table-striped hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Work Number</th>
                                    <th class="whitespace-nowrap">Access Code</th>
                                    <th class="whitespace-nowrap">Current Language</th>
                                    <th class="whitespace-nowrap">Translated Language</th>
                                    <th class="whitespace-nowrap">Payment Status</th>
                                    <th class="whitespace-nowrap">Order Status</th>
                                    <th>Created At</th>
                                    <th class="whitespace-nowrap">Possible Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->orders as $order)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $order->worknumber }}</td>
                                    @if ($order->access_code != null)
                                    <td class="whitespace-nowrap">{{ $order->access_code }}</td>
                                    @else
                                    <td class="whitespace-nowrap">N/A</td>
                                    @endif
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
                                                aria-valuemin="0" aria-valuemax="100">0%</div>
                                        </div>
                                        @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 2)
                                        <div class="progress h-6">
                                            <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100">35%</div>
                                        </div>
                                        @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 3)
                                        <div class="progress h-6">
                                            <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100">25%</div>
                                        </div>
                                        @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0 &&
                                        $order->is_evidence == 1)
                                        <div class="progress h-6">
                                            <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100">35%</div>
                                        </div>
                                        @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                                        <div class="progress h-6">
                                            <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100">25%</div>
                                        </div>
                                        @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 &&
                                        $order->translation_status == 0)
                                        <div class="progress h-6">
                                            <div class="progress-bar w-2/4 bg-primary" role="progressbar"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">50%
                                            </div>
                                        </div>
                                        @elseif (
                                        $order->invoiceSent == 1 &&
                                        $order->paymentStatus == 1 &&
                                        $order->translation_status == 1 &&
                                        $order->proofread_status == 0)
                                        <div class="progress h-6">
                                            <div class="progress-bar w-3/4 bg-pending" role="progressbar"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">75%
                                            </div>
                                        </div>
                                        @elseif (
                                        $order->invoiceSent == 1 &&
                                        $order->paymentStatus == 1 &&
                                        $order->translation_status == 1 &&
                                        $order->proofread_status == 1)
                                        <div class="progress h-6">
                                            <div class="progress-bar w-4/4 bg-success" role="progressbar"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">100%
                                            </div>
                                        </div>
                                        @endif

                                    </td>
                                    {{-- <td class="whitespace-nowrap">
                                        <div>
                                            <a href="javascript:;" data-trigger="click" class="tooltip btn btn-primary"
                                                title="{{ $order->orderStatus }}">Show Status</a>
                                            @if (empty($order->invoice))

                                            @else
                                            <a href="{{ route('viewInvoice',$order->invoice->id) }}"
                                                data-trigger="click" class="tooltip btn btn-primary"
                                                title="{{ $order->orderStatus }}">View Invoice</a>
                                            @endif
                                        </div>
                                    </td> --}}

                                    <td class="whitespace-nowrap">
                                        {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($order->created_at,
                                        request()->ip()) }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @if ($order->invoiceSent == 0)
                                        <button class="btn btn-warning mr-1 mb-2"> Waiting for Invoice <i
                                                data-loading-icon="three-dots" data-color="ffffff"
                                                class="w-4 h-4 ml-2"></i> </button>
                                        @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0 &&
                                        $order->is_evidence == 1)
                                        <button class="btn btn-warning mr-1 mb-2"> Processing Payment Proof <i
                                                data-loading-icon="three-dots" data-color="ffffff"
                                                class="w-4 h-4 ml-2"></i> </button>
                                        @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                                        <a href="{{ route('viewInvoice', $order->invoice->id) }}"
                                            class="btn btn-warning mr-1 mb-2"> View Invoice </a>
                                        @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 3)
                                        <button class="btn btn-pending mr-1 mb-2"> Waiting for Deferred Payment
                                            Approval
                                            <i data-loading-icon="three-dots" data-color="1a202c"
                                                class="w-4 h-4 ml-2"></i> </button>
                                        @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 2)
                                        <button class="btn btn-primary mr-1 mb-2"> Waiting for Translation <i
                                                data-loading-icon="three-dots" data-color="1a202c"
                                                class="w-4 h-4 ml-2"></i> </button>
                                        @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 &&
                                        $order->translation_status == 0)
                                        <button class="btn btn-primary mr-1 mb-2"> Waiting for Translation <i
                                                data-loading-icon="three-dots" data-color="1a202c"
                                                class="w-4 h-4 ml-2"></i> </button>
                                        @elseif (
                                        $order->invoiceSent == 1 &&
                                        $order->paymentStatus == 1 &&
                                        $order->translation_status == 1 &&
                                        $order->proofread_status == 0)
                                        <button class="btn btn-pending mr-1 mb-2"> Waiting for Proofreading <i
                                                data-loading-icon="three-dots" data-color="1a202c"
                                                class="w-4 h-4 ml-2"></i> </button>
                                        @elseif (
                                        $order->invoiceSent == 1 &&
                                        $order->paymentStatus == 1 &&
                                        $order->translation_status == 1 &&
                                        $order->proofread_status == 1 &&
                                        $order->completed == 1)
                                        <a href="{{ route('downloadTranslatedForUser', $order->id) }}"
                                            class="btn btn-warning mr-1 mb-2"> <i data-lucide="download"
                                                class="w-5 h-5 mr-2"> </i>Download Translated Files </a>
                                        <a href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#superlarge-modal-size-preview-{{ $order->id }}"
                                            class="btn btn-success mr-1 mb-2"><i data-lucide="twitch"
                                                class="w-5 h-5"></i></a>
                                        <div id="superlarge-modal-size-preview-{{ $order->id }}" class="modal"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-body p-10">
                                                        <form action="{{ route('submitFeedback') }}" method="post">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="order_id"
                                                                value="{{ $order->id }}">
                                                            <input type="text" name="experience"
                                                                class="intro-x login__input form-control py-3 px-4 block"
                                                                required placeholder="How was your experience with us?">
                                                            <input type="text" name="improvements"
                                                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                                                placeholder="How can we improve our service?">
                                                            <input type="number" name="rating"
                                                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                                                placeholder="How would you rate our service? (0 - 10)">
                                                            <input type="submit" class="btn btn-primary mt-5"
                                                                value="Submit Feedback">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                    <th class="whitespace-nowrap">Work Number</th>
                                    <th class="whitespace-nowrap">Language</th>
                                    <th class="whitespace-nowrap">Interpretation Date</th>
                                    <th class="whitespace-nowrap">Start Time</th>
                                    <th class="whitespace-nowrap">End Time</th>
                                    <th class="whitespace-nowrap">Session Format</th>
                                    <th class="whitespace-nowrap">Created At</th>
                                    <th class="whitespace-nowrap">Status</th>
                                    <th class="whitespace-nowrap">Possible Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->interpretations as $interpretation)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $interpretation->worknumber }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->language }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretationDate }}</td>
                                    <td class="whitespace-nowrap">
                                        {{
                                        App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->start_time,
                                        request()->ip()) }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{
                                        App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->end_time,
                                        request()->ip()) }}
                                    </td>
                                    <td class="whitespace-nowrap">{{ $interpretation->session_format }}</td>


                                    <td class="whitespace-nowrap">
                                        {{
                                        App\Helpers\HelperClass::convertDateToCurrentTimeZone($interpretation->created_at,
                                        request()->ip()) }}
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
                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 &&
                                        $interpretation->paymentStatus == 0)
                                        Payment Required
                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus == 0)
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
                                        <button class="btn btn-success mr-1 mb-2">Interpretation Completed</button>
                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 &&
                                        $interpretation->paymentStatus == 0)
                                        <button class="btn btn-warning mr-1 mb-2">Waiting for Invoice <i
                                                data-loading-icon="three-dots" data-color="1a202c"
                                                class="w-4 h-4 ml-2"></i></button>
                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus == 0)
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
                                        <button class="btn btn-success mr-1 mb-2">Interpretation Completed</button>
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