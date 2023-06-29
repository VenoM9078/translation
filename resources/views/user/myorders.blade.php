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
                                        <th class="whitespace-nowrap">
                                            C. Rate ($/W or $/P)
                                        </th>
                                        <th class="whitespace-nowrap">C. Adjust
                                            ($)
                                        </th>
                                        <th class="whitespace-nowrap">C. Fee
                                            ($)
                                        </th>
                                        <th class="whitespace-nowrap">C. Adjust Note</th>
                                        <th class="whitespace-nowrap">C.Paid</th>
                                        <th class="whitespace-nowrap">Status</th>
                                        <th class="whitespace-nowrap">Created At</th>
                                        <th class="whitespace-nowrap">Possible Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $order->worknumber }}</td>
                                            <td class="whitespace-nowrap">{{ $order->language1 }}</td>
                                            <td class="whitespace-nowrap">{{ $order->language2 }}</td>
                                            <td class="whitespace-nowrap">
                                                <a title="Download Original Document"
                                                    href="{{ route('user.downloadFiles', $order->id) }}"
                                                    class="btn btn-warning mr-1">
                                                    <i data-lucide="download" class="w-5 h-5"></i>
                                                </a>
                                            </td>
                                            @if ($order->message)
                                                <td class="whitespace-nowrap">
                                                    <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#note-modal-preview{{ $order->id }}">
                                                        <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                    </a>
                                                </td>
                                            @else
                                                <td class="whitespace-nowrap">-</td>
                                                </td>
                                            @endif
                                            <td>
                                                @if (isset($order->contractorOrder) && $order->contractorOrder->file_name != '')
                                                    <a class="btn" title="Download Translation"
                                                        href="{{ route('user.download-translation-file', $order->id) }}">
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
                                            <td class="whitespace-nowrap">${{ $order->c_rate }}</td>
                                            <td class="whitespace-nowrap">${{ $order->c_adjust }}</td>
                                            <td class="whitespace-nowrap">{{ $order->c_fee }}</td>
                                            <td title="{{ $order->c_adjust_note ?? '-' }}"><i data-lucide="message-square"
                                                    class="w-100 h-5"> </i>
                                            </td>
                                            <td class="whitespace-nowrap">{{ $order->c_paid }}</td>

                                            <td class="whitespace-nowrap">
                                                @if ($order->want_quote == 0 && $order->translation_status == 0)
                                                    <div class="w-full">
                                                        Translation Requested
                                                    </div>
                                                @elseif ($order->want_quote == 1)
                                                    <div class="w-full">
                                                        Quote Requested
                                                    </div>
                                                @elseif($order->want_quote == 2)
                                                    <div class="w-full">
                                                        Quote Ready
                                                    </div>
                                                @elseif ($order->contractorOrder->is_accepted == 1 && $order->translation_status == 0)
                                                    <div class="w-full">
                                                        Translation In Progress
                                                    </div>
                                                @elseif ($order->translation_status == \App\Enums\TranslationStatusEnum::COMPLETED)
                                                    <div class="w-full">
                                                        Translation Completed
                                                    </div>
                                                @elseif ($order->orderStatus == 'Cancelled')
                                                    <div class="w-full">
                                                        Cancelled
                                                    </div>
                                                @else
                                                    <div class="w-full">
                                                        -
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
                                                    <button class="btn btn-warning mr-1 mb-2"> Processing Payment Proof
                                                        <i data-loading-icon="three-dots" data-color="ffffff"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                                                    @if ($order->invoice != null)
                                                        <a href="{{ route('viewInvoice', $order->invoice->id) }}"
                                                            class="btn btn-warning mr-1 mb-2"> View Invoice </a>
                                                    @else
                                                        <span>No Invoice</span>
                                                    @endif
                                                @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 3)
                                                    <button class="btn btn-pending mr-1 mb-2"> Waiting for Deferred
                                                        Payment
                                                        Approval
                                                        <i data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 2)
                                                    <button class="btn btn-primary mr-1 mb-2"> Waiting for Translation
                                                        <i data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 0)
                                                    <button class="btn btn-primary mr-1 mb-2"> Waiting for Translation
                                                        <i data-loading-icon="three-dots" data-color="1a202c"
                                                            class="w-4 h-4 ml-2"></i> </button>
                                                @elseif (
                                                    $order->invoiceSent == 1 &&
                                                        $order->paymentStatus == 1 &&
                                                        $order->translation_status == 1 &&
                                                        $order->proofread_status == 0)
                                                    <button class="btn btn-pending mr-1 mb-2"> Waiting for Proofreading
                                                        <i data-loading-icon="three-dots" data-color="1a202c"
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
                                                    @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <!-- BEGIN: Modal Content -->
                                        <div id="note-modal-preview{{ $order->id }}" class="modal" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body p-0">
                                                        <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                            <div class="text-3xl mt-5 mb-2">Order Note</div>
                                                            <div class="w-full text-left">
                                                                <label for="order-form-21" class="form-label">Client
                                                                    Message:</label>
                                                                <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $order->message }}</textarea>
                                                            </div>
                                                            <div class="w-full text-left">
                                                                <label for="order-form-21" class="form-label">Admin
                                                                    Message:</label>
                                                                <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $order->quote() ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- END: Modal Content -->
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
