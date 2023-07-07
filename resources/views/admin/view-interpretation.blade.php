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
                                value="{{ $interpretation->user->name }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-2" class="form-label">Email</label>
                            <input id="order-form-2" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->user->email }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN: Order Details -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Interpretation Details
                </h2>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-1" class="form-label">WO#</label>
                            <input id="order-form-1" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->worknumber }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-2" class="form-label">Language</label>
                            <input id="order-form-2" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->language }}">
                        </div>
                    </div>
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-3" class="form-label">Interpretation Date</label>
                            <input id="order-form-3" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->interpretationDate }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-4" class="form-label">Start Time</label>
                            <input id="order-form-4" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->start_time }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-5" class="form-label">End Time</label>
                            <input id="order-form-5" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->end_time }}">
                        </div>
                    </div>
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-8" class="form-label">Session Format</label>
                            <input id="order-form-8" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->session_format }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-9" class="form-label">Location</label>
                            <input id="order-form-9" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->location }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-10" class="form-label">Session Topics</label>
                            <input id="order-form-10" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->session_topics }}">
                        </div>
                    </div>
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-11" class="form-label">Want Quote</label>
                            <input id="order-form-11" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->wantQuote == 1 ? 'Yes' : 'No' }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-12" class="form-label">Quote Price</label>
                            <input id="order-form-12" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->quote_price }}">
                        </div>

                        <div class="w-full">
                            <label for="order-form-14" class="form-label">Invoice Sent</label>
                            <input id="order-form-14" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->invoiceSent == 1 ? 'Yes' : 'No' }}">
                        </div>
                    </div>
                    <div class="w-full">
                        <label for="order-form-13" class="form-label">Quote Description</label>
                        <textarea id="order-form-13" type="text" class="form-control w-full" disabled
                            value="{{ $interpretation->quote_description }}">{{ $interpretation->quote_description }}</textarea>
                    </div>
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-14" class="form-label">Invoice Sent</label>
                            <input id="order-form-14" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->invoiceSent == 1 ? 'Yes' : 'No' }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-15" class="form-label">Payment Status</label>
                            <input id="order-form-15" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->paymentStatus == 1 ? 'Paid' : 'Not Paid' }}">
                        </div>
                        {{-- <div class="w-full">
                            <label for="order-form-16" class="form-label">Interpreter ID</label>
                            <input id="order-form-16" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->interpreter_id }}">
                        </div> --}}
                    </div>
                    <div class="flex gap-2 w-full">

                        <!-- C. Type field -->
                        <div class="w-full">
                            <label for="c_type">C. Type</label>
                            <input type="text" id="c_type" name="c_type"
                                class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" placeholder="C. Type"
                                value="{{ $interpretation->c_type }}">
                        </div>

                        <!-- C. Unit field -->
                        <div class="w-full">
                            <label for="c_unit">C. Unit</label>
                            <input type="number" id="c_unit" name="c_unit"
                                class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" placeholder="C. Unit"
                                value="{{ $interpretation->c_unit }}">
                        </div>

                    </div>
                    <div class="flex gap-2 w-full">

                        <!-- C. Rate field -->
                        <div class="w-full">

                            <label for="c_rate">C. Rate ($/W or $/P)</label>
                            <input type="number" step="0.01" id="c_rate" name="c_rate"
                                class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                placeholder="C. Rate ($/W or $/P)" value="{{ $interpretation->c_rate }}">
                        </div>
                        <!-- C. Adjust field -->
                        <div class="w-full">

                            <label for="c_adjust">C. Adjust ($)</label>
                            <input type="number" step="0.01" id="c_adjust" name="c_adjust"
                                class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                placeholder="C. Adjust ($)" value="{{ $interpretation->c_adjust }}">
                        </div>
                    </div>

                    <div class="flex gap-2 w-full">

                        <!-- C. Paid field -->
                        <div class="w-full">
                            <label for="c_paid">C. Paid</label>
                            <select id="c_paid" name="c_paid" class="form-control py-3 px-4 block mt-4 mb-4">
                                <option value="0" {{ $interpretation->c_paid == 0 ? 'selected' : '' }}>No
                                </option>
                                <option value="1" {{ $interpretation->c_paid == 1 ? 'selected' : '' }}>Yes
                                </option>
                            </select>
                        </div>
                        <!-- C. Fee field -->
                        <div class="w-full">

                            <label for="c_fee">C. Fee ($)</label>
                            <input type="number" step="0.01" id="c_fee" name="c_fee"
                                class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                placeholder="C. Fee ($)" value="{{ $interpretation->c_fee }}">
                        </div>
                    </div>
                    <!-- C. Adjust Note field -->
                    <label for="c_adjust_note">C. Adjust Note</label>
                    <textarea id="c_adjust_note" name="c_adjust_note" class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                        placeholder="C. Adjust Note">{{ $interpretation->c_adjust_note }}</textarea>
                    
                    <div class="flex mt-2 mb-2 gap-2">
                        <div class="w-full">
                            <label for="order-form-17" class="form-label">Interpreter Completed</label>
                            <input id="order-form-17" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->interpreter_completed == 1 ? 'Yes' : 'No' }}">
                        </div>
                        <div class="w-full">
                            <label for="order-form-18" class="form-label">Feedback</label>
                            <input id="order-form-18" type="text" class="form-control w-full" disabled
                                value="{{ $interpretation->feedback }}">
                        </div>
                    </div>

                    <!-- Add more input fields here following the pattern above -->

                </div>
                <a href="{{ url()->previous() }}" class="btn btn-primary mt-2">Back</a>
            </div>
        </div>
    </div>
@endsection
