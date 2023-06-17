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
                                        <th class="whitespace-nowrap">WO#</th>
                                        <th class="whitespace-nowrap">Source Language</th>
                                        <th class="whitespace-nowrap">Target Language</th>
                                        <th class="whitespace-nowrap">Original Document</th>
                                        <th class="whitespace-nowrap">Quote</th>
                                        <th class="whitespace-nowrap">Translated Document</th>
                                        <th class="whitespace-nowrap">Message</th>
                                        <th class="whitespace-nowrap">Type</th>
                                        <th class="whitespace-nowrap">Unit</th>
                                        <th class="whitespace-nowrap">Order Status</th>
                                        <th class="whitespace-nowrap">Payment Status</th>

                                        <th class="whitespace-nowrap">Created At</th>
                                        <th class="whitespace-nowrap">Possible Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->orders as $order)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $order->worknumber }}</td>
                                            <td class="whitespace-nowrap">{{ $order->language1 }}</td>
                                            <td class="whitespace-nowrap">{{ $order->language2 }}</td>
                                            <td class="whitespace-nowrap">
                                                <a title="Download Original Document"
                                                    href="{{ route('downloadFiles', $order->id) }}"
                                                    class="btn btn-warning mr-1">
                                                    <i data-lucide="download" class="w-5 h-5"></i>
                                                </a>
                                            </td>
                                             <td title="{{ $order->quote() ?? '-'}}"><i data-lucide="message-square"
                                                    class="w-100 h-5"> </i>
                                            </td>
                                            <td>
                                                @if (isset($order->contractorOrder) && $order->contractorOrder->file_name != '')
                                                    <a class="btn" title="Download Translation"
                                                        href="{{ route('download-translation-file', $order->id) }}">
                                                        <i data-lucide="download" class="w-5 h-5"></i>
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td title="{{ $order->message }}"><i data-lucide="message-square"
                                                    class="w-100 h-5"> </i>
                                            </td>
                                            <td class="whitespace-nowrap">By Word</td>
                                            <td class="whitespace-nowrap">
                                                {{ $order->unit ?? '-' }}</td>
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
                                                @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0 && $order->is_evidence == 1)
                                                    <div class="progress h-6">
                                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                                            aria-valuemin="0" aria-valuemax="100">35%</div>
                                                    </div>
                                                @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                                                    <div class="progress h-6">
                                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                                            aria-valuemin="0" aria-valuemax="100">25%</div>
                                                    </div>
                                                @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 0)
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
                                            <td class="whitespace-nowrap">
                                                {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($order->created_at, request()->ip()) }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($order->invoiceSent == 0)
                                                    <button class="btn btn-warning mr-1 mb-2"> Waiting for Invoice <i
                                                            data-loading-icon="three-dots" data-color="ffffff"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0 && $order->is_evidence == 1)
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
                                                @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 0)
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
                                                    <div id="superlarge-modal-size-preview-{{ $order->id }}"
                                                        class="modal" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-10">
                                                                    <form action="{{ route('submitFeedback') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="order_id"
                                                                            value="{{ $order->id }}">
                                                                        <input type="text" name="experience"
                                                                            class="intro-x login__input form-control py-3 px-4 block"
                                                                            required
                                                                            placeholder="How was your experience with us?">
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




    <script>
        let button = document.querySelector('#uniqueModal');

        button.addEventListener('click', function() {
            let value = button.value;

            console.log(value);
        })
    </script>
@endsection
