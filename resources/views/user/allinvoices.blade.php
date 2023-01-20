@extends('user.layout')

@section('content')
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                All Invoices
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
                                        <th class="whitespace-nowrap">Description</th>
                                        <th class="whitespace-nowrap">Quantity (Words / Pages)</th>
                                        <th class="whitespace-nowrap">Amount</th>
                                        <th>Created At</th>
                                        <th class="whitespace-nowrap">Possible Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $invoice->description }}</td>

                                            <td class="whitespace-nowrap">{{ $invoice->docQuantity }}</td>
                                            <td class="whitespace-nowrap">${{ $invoice->amount }}</td>

                                            <td class="whitespace-nowrap">{{ $invoice->created_at }}</td>

                                            <td class="whitespace-nowrap">
                                                @if ($invoice->order->paymentStatus == 0)
                                                    <button class="btn btn-warning mr-1 mb-2"> Waiting for Payment <i
                                                            data-loading-icon="three-dots" data-color="ffffff"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif ($invoice->order->paymentStatus == 1)
                                                    <button class="btn btn-success mr-1 mb-2"> Payment Paid <i
                                                            data-loading-icon="three-dots" data-color="ffffff"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif ($invoice->order->invoiceSent == 1 && $invoice->order->paymentStatus == 0)
                                                    <a href="{{ route('viewInvoice', $invoice->order->invoice->id) }}"
                                                        class="btn btn-warning mr-1 mb-2"> View Invoice </a>
                                                @elseif ($invoice->order->invoiceSent == 1 && $invoice->order->paymentStatus == 3)
                                                    <button class="btn btn-pending mr-1 mb-2"> Waiting for Deferred Payment
                                                        Approval
                                                        <i data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif ($invoice->order->invoiceSent == 1 && $invoice->order->paymentStatus == 2)
                                                    <button class="btn btn-primary mr-1 mb-2"> Waiting for Translation <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif (
                                                    $invoice->order->invoiceSent == 1 &&
                                                        $invoice->order->paymentStatus == 1 &&
                                                        $invoice->order->translation_status == 0)
                                                    <button class="btn btn-primary mr-1 mb-2"> Waiting for Translation <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif (
                                                    $invoice->order->invoiceSent == 1 &&
                                                        $invoice->order->paymentStatus == 1 &&
                                                        $invoice->order->translation_status == 1 &&
                                                        $invoice->order->proofread_status == 0)
                                                    <button class="btn btn-pending mr-1 mb-2"> Waiting for Proofreading <i
                                                            data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif (
                                                    $invoice->order->invoiceSent == 1 &&
                                                        $invoice->order->paymentStatus == 1 &&
                                                        $invoice->order->translation_status == 1 &&
                                                        $invoice->order->proofread_status == 1 &&
                                                        $invoice->order->completed == 1)
                                                    <a href="{{ route('downloadTranslatedForUser', $invoice->order->id) }}"
                                                        class="btn btn-warning mr-1 mb-2"> <i data-lucide="download"
                                                            class="w-5 h-5 mr-2"> </i>Download Translated Files </a>
                                                    <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#superlarge-modal-size-preview-{{ $invoice->order->id }}"
                                                        class="btn btn-success mr-1 mb-2"><i data-lucide="twitch"
                                                            class="w-5 h-5"></i></a>
                                                    <div id="superlarge-modal-size-preview-{{ $invoice->order->id }}"
                                                        class="modal" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-10">
                                                                    <form action="{{ route('submitFeedback') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="order_id"
                                                                            value="{{ $invoice->order->id }}">
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
