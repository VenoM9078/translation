@extends('user.layout')

@section('content')
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            Translation Orders
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
                                    <th class="whitespace-nowrap">Action</th>
                                    <th class="whitespace-nowrap">WO#</th>
                                    @if (Auth::user()->role_id == 2)
                                    <th class="whitespace-nowrap">Requester</th>
                                    @endif
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

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                <tr>
                                    <td class="whitespace-nowrap">
                                        <div class="flex gap-1 items-center">
                                            <div class="text-center mb-2 mr-1">
                                                <a href="{{ route('show-order', $order->id) }}" class="btn btn-primary">
                                                    <svg class="w-5 h-5 text-white mx-auto"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                                    </svg>

                                                </a>
                                            </div>
                                            <div class="text-center mb-2 mr-1"> <a href="javascript:;"
                                                    data-tw-toggle="modal"
                                                    data-tw-target="#track-modal-preview{{ $order->id }}" title="Track"
                                                    class="btn btn-success">
                                                    <svg class="w-5 h-5 text-white mx-auto"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>

                                                </a>
                                            </div>
                                            <div id="track-modal-preview{{ $order->id }}" class="modal" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="target"
                                                                    class="w-16 h-16 text-success mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5">Track Order</div>
                                                            </div>
                                                            <div class="intro-y box py-10 mt-5">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($order->contractorOrder == null && $order->proofReaderOrder == null)
                                            <div class="text-center mb-2 mr-1">
                                                <form action="{{ route('cancelOrder') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <button type="submit" class="btn btn-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                                                            class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                            @if (Auth::user()->role_id == 2)
                                            {{-- Edit --}}
                                            <div class="text-center mb-2 mr-1">
                                                <a href="{{ route('view-edit-order', $order->id) }}"
                                                    class="btn btn-warning" title="Edit">
                                                    <svg class="w-5 h-5 text-white mx-auto"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>

                                                </a>
                                            </div>
                                            @endif

                                            {{-- Copy --}}
                                            @if (Auth::user()->role_id == 1 && Auth::user()->role_id == 2)
                                            <div class="text-center mb-2 mr-1">
                                                <a href="{{ route('copy-order', $order->id) }}"
                                                    class="btn btn-pending"><svg
                                                        class="w-4 h-4 text-white dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 16 20">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M2 5a1 1 0 0 0-1 1v12a.969.969 0 0 0 .933 1h8.1a1 1 0 0 0 1-1.033M10 1v4a1 1 0 0 1-1 1H5m10-4v12a.97.97 0 0 1-.933 1H5.933A.97.97 0 0 1 5 14V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 9.828 1h4.239A.97.97 0 0 1 15 2Z" />
                                                    </svg></a>
                                            </div>
                                            @endif

                                            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 0)
                                            @if (isset($order->is_order_quote_accepted) &&
                                            $order->is_order_quote_accepted == 0 && $order->want_quote == 1)
                                            <div class="flex gap-2">
                                                <div>
                                                    <div class="text-center mb-2 mr-1"> <a href="javascript:;"
                                                            data-tw-toggle="modal"
                                                            data-tw-target="#translation-modal-accept-{{ $key }}"
                                                            class="btn btn-success">View Quote</a>
                                                    </div>
                                                </div>

                                            </div>
                                            @endif
                                            @endif

                                            <div id="translation-modal-accept-{{ $key }}" class="modal" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    icon-name="check-circle" data-lucide="check-circle"
                                                                    class="lucide lucide-check-circle w-16 h-16 text-success mx-auto mt-3">
                                                                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14">
                                                                    </path>
                                                                    <polyline points="22 4 12 14.01 9 11.01">
                                                                    </polyline>
                                                                </svg>
                                                                <div class="text-3xl mt-5">Are you sure?</div>
                                                                <div class="text-slate-500 mt-2">Your action
                                                                    will
                                                                    advance
                                                                    this
                                                                    request and notify the user of your
                                                                    agreement!
                                                                </div>
                                                                <div class="w-full text-left">
                                                                    <label for="order-form-21" class="form-label">
                                                                        Quote Price ($):</label>
                                                                    <input id="order-form-21" type="text"
                                                                        class="form-control" disabled
                                                                        value="{{ $order->quote_price }}" />
                                                                    <label for="order-form-21" class="form-label">
                                                                        Quote Description:</label>
                                                                    <textarea id="order-form-21" type="text"
                                                                        class="form-control"
                                                                        disabled>{{ $order->quote_description }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">

                                                                <a href="{{ route('user.approve-quote', $order->id) }}"
                                                                    class="btn btn-success text-white w-24 mr-1 self-center">
                                                                    Approve</a>
                                                                <a href="{{ route('user.disapprove-quote', $order->id) }}"
                                                                    class="btn btn-danger w-24 mr-1 self-center">
                                                                    Disapprove</a>
                                                                <button type="button" data-tw-dismiss="modal"
                                                                    class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->

                                            <!-- BEGIN: Modal Content -->
                                            <div id="translation-modal-reject-{{ $key }}" class="modal" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                                    class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5">Are you sure?</div>
                                                                <div class="text-slate-500 mt-2">Rejecting will
                                                                    delete this
                                                                    request from your Dashboard and notify the
                                                                    user
                                                                    of your
                                                                    actions.</div>
                                                            </div>
                                                            <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                <a href="{{ route('user.disapprove-quote', $order->id) }}"
                                                                    class="btn btn-danger w-24 mr-1 self-center">
                                                                    I'm Sure</a>
                                                                <button type="button" data-tw-dismiss="modal"
                                                                    class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            @if ($order->invoiceSent == 0 && Auth::user()->role_id != 2 && 1 == 2)
                                            <button class="btn btn-warning mr-1 mb-2"> Waiting for Invoice
                                                <i data-loading-icon="three-dots" data-color="ffffff"
                                                    class="w-4 h-4 ml-2"></i> </button>
                                            @elseif (
                                            $order->invoiceSent == 1 &&
                                            $order->paymentStatus == 0 &&
                                            $order->is_evidence == 1 &&
                                            Auth::user()->role_id != 2 &&
                                            1 == 2)
                                            <button class="btn btn-warning mr-1 mb-2"> Processing Payment
                                                Proof
                                                <i data-loading-icon="three-dots" data-color="ffffff"
                                                    class="w-4 h-4 ml-2"></i> </button>
                                            @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                                            @if ($order->invoice != null)
                                            <a href="{{ route('viewInvoice', $order->invoice->id) }}"
                                                class="btn btn-warning mr-1 mb-2"> View Invoice </a>
                                            @endif
                                            @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 3 &&
                                            Auth::user()->role_id != 2)
                                            <button class="btn btn-pending mr-1 mb-2"> Waiting for Deferred
                                                Payment
                                                Approval
                                                <i data-loading-icon="three-dots" data-color="1a202c"
                                                    class="w-4 h-4 ml-2"></i> </button>
                                            @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 2 && 1 == 2)
                                            <button class="btn btn-primary mr-1 mb-2"> Waiting for
                                                Translation
                                                <i data-loading-icon="three-dots" data-color="1a202c"
                                                    class="w-4 h-4 ml-2"></i> </button>
                                            @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 &&
                                            $order->translation_status == 0 && 1 == 2)
                                            <button class="btn btn-primary mr-1 mb-2"> Waiting for
                                                Translation
                                                <i data-loading-icon="three-dots" data-color="1a202c"
                                                    class="w-4 h-4 ml-2"></i> </button>
                                            @elseif (
                                            $order->invoiceSent == 1 &&
                                            $order->paymentStatus == 1 &&
                                            $order->translation_status == 1 &&
                                            $order->proofread_status == 0 &&
                                            1 == 2)
                                            <button class="btn btn-pending mr-1 mb-2"> Waiting for
                                                Proofreading
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
                                                    class="w-5 h-5 mr-2">
                                                </i>Download Translated Files </a>
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
                                            @endif
                                    </td>

                                    <td class="whitespace-nowrap">{{ $order->worknumber }}</td>
                                    @if (Auth::user()->role_id == 2)
                                    <td class="whitespace-nowrap">{{ $order->user->email }}</td>
                                    @endif
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
                                    <td class="whitespace-nowrap">
                                        <a href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#order-message-modal-preview{{ $order->id }}">
                                            <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                        </a>
                                    </td>
                                    <!-- BEGIN: Modal Content -->
                                    <div id="order-message-modal-preview{{ $order->id }}" class="modal" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                            class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                        <div class="text-3xl mt-5 mb-2">Order Message</div>
                                                        <div class="w-full text-left">
                                                            <label for="order-form-21" class="form-label">
                                                                Message:</label>
                                                            <textarea id="order-form-21" type="text"
                                                                class="form-control"
                                                                disabled>{{ $order->message }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- END: Modal Content -->
                                    <td class="whitespace-nowrap">By Word</td>
                                    <td class="whitespace-nowrap">
                                        {{ $order->unit ?? '-' }}</td>
                                    <td class="whitespace-nowrap">${{ $order->c_rate }}</td>
                                    <td class="whitespace-nowrap">${{ $order->c_adjust }}</td>
                                    <td class="whitespace-nowrap">{{ $order->c_fee }}</td>
                                    {{-- Quote --}}
                                    <td class="whitespace-nowrap">
                                        <a href="javascript:;" data-tw-toggle="modal"
                                            data-tw-target="#c-note-modal-preview{{ $order->id }}">
                                            <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                        </a>
                                    </td>
                                    <!-- BEGIN: Modal Content -->
                                    <div id="c-note-modal-preview{{ $order->id }}" class="modal" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                            class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                        <div class="text-3xl mt-5 mb-2">Order C. Note</div>
                                                        <div class="w-full text-left">
                                                            <label for="order-form-21" class="form-label">Quote
                                                                Message:</label>
                                                            <textarea id="order-form-2" type="text" class="form-control"
                                                                disabled>{{ $order->c_adjust_note }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- END: Modal Content -->
                                    <td class="whitespace-nowrap">{{ $order->c_paid == 1 ? 'Yes' : 'No' }}
                                    </td>

                                    <td class="whitespace-nowrap">
                                        @include('utils.order-status-column', ['order' => $order])

                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($order->created_at,
                                        request()->ip()) }}
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
                                                        <textarea id="order-form-21" type="text" class="form-control"
                                                            disabled>{{ $order->message }}</textarea>
                                                    </div>
                                                    <div class="w-full text-left">
                                                        <label for="order-form-21" class="form-label">Admin
                                                            Message:</label>
                                                        <textarea id="order-form-21" type="text" class="form-control"
                                                            disabled>{{ $order->quote() ?? '' }}</textarea>
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



<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script>
    $(document).on('click', '.btn.btn-success', function() {
            var orderId = $(this).data('tw-target').replace('#track-modal-preview', '');
            console.log("Clicked Track ", orderId);
            $.get('/user/order/' + orderId + '/track', function(data) {
                $('.intro-y.box.py-10.mt-5').html(data);
            });
        });
</script>
@endsection