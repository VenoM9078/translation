@extends('admin.layout')

@section('content')
    <div class="col-span-12">
        {{-- Customer Details --}}
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Customer Details
                </h2>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-1" class="form-label">Username</label>
                            <input id="order-form-1" type="text" class="form-control w-full" disabled
                                value="{{ $order->user->name }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-2" class="form-label">Email</label>
                            <input id="order-form-2" type="text" class="form-control w-full" disabled
                                value="{{ $order->user->email }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN: Order Details -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Order Details
                </h2>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-1" class="form-label">WO#</label>
                            <input id="order-form-1" type="text" class="form-control w-full" disabled
                                value="{{ $order->worknumber }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-19" class="form-label">Order Completed</label>
                            <input id="order-form-19" type="text" class="form-control" disabled
                                value="{{ $order->completed == 1 ? 'Yes' : 'No' }}">
                        </div>

                    </div>
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-2" class="form-label">Source Language</label>
                            <input id="order-form-2" type="text" class="form-control w-full" disabled
                                value="{{ $order->language1 }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-3" class="form-label">Target Language</label>
                            <input id="order-form-3" type="text" class="form-control w-full" disabled
                                value="{{ $order->language2 }}">
                        </div>
                    </div>

                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-9" class="form-label">Invoice Sent</label>
                            <input id="order-form-9" type="text" class="form-control" disabled
                                value="{{ $order->invoiceSent == 1 ? 'Yes' : 'No' }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-10" class="form-label">Is Evidence</label>
                            <input id="order-form-10" type="text" class="form-control" disabled
                                value="{{ $order->is_evidence == 1 ? 'Yes' : 'No' }}">
                        </div>
                    </div>
                    <div class="w-full">
                        <label for="order-form-11" class="form-label">Filename</label>
                        <input id="order-form-11" type="text" class="form-control" disabled
                            value="{{ $order->filename }}">
                    </div>
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-12" class="form-label">Evidence Accepted</label>
                            <input id="order-form-12" type="text" class="form-control" disabled
                                value="{{ $order->evidence_accepted == 1 ? 'Yes' : 'No' }}">
                        </div>

                        <div class="w-full">
                            <label for="order-form-13" class="form-label">Amount</label>
                            <input id="order-form-13" type="text" class="form-control" disabled
                                value="{{ $order->amount }}">
                        </div>
                    </div>
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full col-md-6">
                            <label for="order-form-14" class="form-label">Order Status</label>
                            <input id="order-form-14" type="text" class="form-control" disabled
                                value="{{ $order->orderStatus }}">
                        </div>
                        <div class="w-full col-md-6">
                            <label for="order-form-15" class="form-label">Translation Sent</label>
                            <input id="order-form-15" type="text" class="form-control" disabled
                                value="{{ $order->translation_sent == 1 ? 'Yes' : 'No' }}">
                        </div>
                    </div>
                    <div class="flex mt-2 mb-2 gap-3">
                        <div class="w-full">
                            <label for="order-form-16" class="form-label">Translation Status</label>
                            <input id="order-form-16" type="text" class="form-control" disabled
                                value="{{ $order->translation_status == 1 ? 'Completed' : 'Incomplete' }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-17" class="form-label">Proofread Sent</label>
                            <input id="order-form-17" type="text" class="form-control" disabled
                                value="{{ $order->proofread_sent == 1 ? 'Yes' : 'No' }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-18" class="form-label">Proofread Status</label>
                            <input id="order-form-18" type="text" class="form-control" disabled
                                value="{{ $order->proofread_status == 1 ? 'Yes' : 'No' }}">
                        </div>
                    </div>
                    <div class="flex mt-2 mb-2 gap-2">

                        <div class="w-full">
                            <label for="order-form-20" class="form-label">Added by Institute User</label>
                            <input id="order-form-20" type="text" class="form-control" disabled
                                value="{{ $order->added_by_institute_user == 1 ? 'Yes' : 'No' }}">
                        </div>

                    </div>
                    <div class="w-full">
                        <label for="order-form-21" class="form-label">Message</label>
                        <input id="order-form-21" type="text" class="form-control" disabled
                            value="{{ $order->message }}">
                    </div>
                    <div class="w-full">
                        <label for="order-form-22" class="form-label">Want Quote</label>
                        <input id="order-form-22" type="text" class="form-control" disabled
                            value="{{ $order->want_quote == 1 ? 'Yes' : 'No' }}">
                    </div>
                </div>
            </div>
        </div>
        {{-- Payment Details --}}
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Payment Details
                </h2>
            </div>
            <div class="p-5">
                <div class="flex mt-2 mb-2 gap-3">
                    <div class="w-full">
                        <label for="order-form-7" class="form-label">Payment Later Approved</label>
                        <input id="order-form-7" type="text" class="form-control" disabled
                            value="{{ $order->paymentLaterApproved == 1 ? 'Yes' : 'No' }}">
                    </div>
                    <div class="w-full">
                        <label for="order-form-8" class="form-label">Pay Later Code</label>
                        <input id="order-form-8" type="text" class="form-control" disabled
                            value="{{ $order->payLaterCode }}">
                    </div>
                    <div class="w-full">
                        <label for="order-form-6" class="form-label">Payment Status</label>
                        <input id="order-form-6" type="text" class="form-control" disabled
                            value="{{ $order->paymentStatus == 1 ? 'Paid' : ($order->paymentStatus == 0 ? 'Not Paid' : 'Payment Paid Late') }}">
                    </div>
                </div>
            </div>
            {{-- <div class="flex mt-2 mb-2 gap-2">

                        <div class="w-full">
                            <label for="order-form-6" class="form-label">Payment Status</label>
                            <input id="order-form-6" type="text" class="form-control" disabled
                                value="{{ $order->paymentStatus == 1 ? 'Yes' : 'No' }}">
                        </div>
                    </div> --}}
        </div>
    </div>
    @if (isset($order->contractorOrder))
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Contractor Details
                </h2>
            </div>
            <div class="p-5">
                <div class="flex mt-2 mb-2 gap-2">
                    <div class="w-full">
                        <label for="order-form-4" class="form-label">Contractor Name</label>
                        <input id="order-form-4" type="text" class="form-control w-full" disabled
                            value="{{ $order->contractorOrder->contractor->name }}">
                    </div>
                    <div class="w-full">
                        <label for="order-form-5" class="form-label">Contractor Email</label>
                        <input id="order-form-5" type="text" class="form-control w-full" disabled
                            value="{{ $order->contractorOrder->contractor->email }}">
                    </div>
                </div>
                <div class="flex mt-2 mb-2 gap-2">
                    <div class="w-full">
                        <label for="order-form-6" class="form-label">SSN</label>
                        <input id="order-form-6" type="text" class="form-control" disabled
                            value="{{ $order->contractorOrder->contractor->SSN }}">
                    </div>
                    <div class="w-full">
                        <label for="order-form-7" class="form-label">Interpretation Rate</label>
                        <input id="order-form-7" type="text" class="form-control" disabled
                            value="${{ $order->contractorOrder->contractor->interpretation_rate }}">
                    </div>
                </div>
                <div class="flex mt-2 mb-2 gap-2">
                    <div class="w-full">
                        <label for="order-form-8" class="form-label">Translation Rate</label>
                        <input id="order-form-8" type="text" class="form-control" disabled
                            value="${{ $order->contractorOrder->contractor->translation_rate }}">
                    </div>
                    <div class="w-full">
                        <label for="order-form-9" class="form-label">Proofreader Rate</label>
                        <input id="order-form-9" type="text" class="form-control" disabled
                            value="${{ $order->contractorOrder->contractor->proofreader_rate }}">
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- @dd($order->invoice) --}}
    @if (isset($order->invoice) && $order->added_by_institute_user == 0)
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Invoice Details
                </h2>
            </div>
            <div class="p-5">
                <div class="flex mt-2 mb-2 gap-2">
                    <div class="w-full">
                        <label for="order-form-10" class="form-label">Invoice Description</label>
                        <input id="order-form-10" type="text" class="form-control" disabled
                            value="{{ $order->invoice->description }}">
                    </div>
                    <div class="w-full">
                        <label for="order-form-11" class="form-label">Document Quantity</label>
                        <input id="order-form-11" type="text" class="form-control" disabled
                            value="{{ $order->invoice->docQuantity }}">
                    </div>
                    <div class="w-full">
                        <label for="order-form-12" class="form-label">Amount</label>
                        <input id="order-form-12" type="text" class="form-control" disabled
                            value="{{ $order->invoice->amount }}">
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
@endsection
