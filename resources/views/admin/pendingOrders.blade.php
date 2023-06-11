@extends('admin.layout')

@section('content')
 <style>
        #dropdownList {
            position: absolute;
            top: 100%;
            z-index: 99999999 !important;
            /* This positions the top edge of the dropdown at the bottom of the container */
            left: 0;
            /* This aligns the dropdown to the left of the container */
            /* Other styles... */
        }

        #dropdownListGroup {
            position: absolute;
            top: 100%;
            z-index: 99999999 !important;
            /* This positions the top edge of the dropdown at the bottom of the container */
            left: 0;
            /* This aligns the dropdown to the left of the container */
            /* Other styles... */
        }

        #dropdownListStatus {
            position: absolute;
            top: 100%;
            z-index: 99999999 !important;
            /* This positions the top edge of the dropdown at the bottom of the container */
            left: 0;
        }
    </style>
     <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    {{--
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css" /> --}}
    <link rel="stylesheet" type="text/css" {{--
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" /> --}} <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

</div>

<div class="intro-y flex items-center h-10 mb-5 mt-2">
    <h2 class="text-lg font-medium truncate ml-2 mr-5">
        Orders
    </h2>
</div>
<hr style="margin-bottom: 30px;">
<!-- BEGIN: Data List -->
{{-- DropDown --}}
<div class="flex justify-end gap-4">
            <div class="dropdown-container relative inline-block my-2">
                <button id="dropdownBgHoverButton" data-dropdown-toggle="dropdownBgHover"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">Filter Columns<svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg></button>

                <!-- Dropdown menu -->
                <div id="dropdownList" class="z-10 hidden w-48 bg-white rounded-lg shadow dark:bg-gray-700">
                    <ul class="space-y-1 overflow-y-auto h-40 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownBgHoverButton">

                    </ul>
                </div>
            </div>
            <div class="dropdown-container relative inline-block my-2">
                <button id="dropdownBgHoverButtonGroup" data-dropdown-toggle="dropdownBgHoverGroup"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">Filter Groups<svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg></button>

                <!-- Dropdown menu -->
                <div id="dropdownListGroup" class="z-10 hidden bg-white rounded-lg shadow dark:bg-gray-700">
                    <ul class=" space-y-1 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownBgHoverButtonGroup">

                    </ul>
                </div>
            </div>

            <div class="dropdown-container relative inline-block my-2">
                <button id="dropdownBgHoverButtonStatus" data-dropdown-toggle="dropdownBgHoverStatus"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">Status<svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg></button>

                <!-- Dropdown menu -->
                <div id="dropdownListStatus" class="z-10 hidden bg-white rounded-lg shadow dark:bg-gray-700">
                    <ul class=" space-y-1 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownBgHoverButtonStatus">
                        <li>
                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input checked id="checkbox-status-pending" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 status-filter"
                                    data-status="pending">
                                <label for="checkbox-status-pending"
                                    class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Pending</label>
                            </div>
                        </li>
                         <li>
                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input checked id="checkbox-status-cancelled" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 status-filter"
                                    data-status="pending">
                                <label for="checkbox-status-cancelled"
                                    class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Cancelled</label>
                            </div>
                        </li>
                         <li>
                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input checked id="checkbox-status-invoice-pending" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 status-filter"
                                    data-status="pending">
                                <label for="checkbox-status-invoice-pending"
                                    class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Invoice Pending</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input checked id="checkbox-status-completed" type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 status-filter"
                                    data-status="completed">
                                <label for="checkbox-status-completed"
                                    class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Completed</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
{{-- DropDown End --}}
<div class="intro-y box">
    <div id="vertical-form" class="p-5">
        <div class="preview">
            <div>
                <div class="overflow-x-auto">
                    <table id="ordersTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">Actions</th>
                                <th class="whitespace-nowrap">Next Step</th>
                                <th class="whitespace-nowrap">Name</th>
                                <th class="whitespace-nowrap">Email</th>
                                <th class="whitespace-nowrap">Order Status</th>
                                <th class="whitespace-nowrap">Order Note</th>
                                <th class="whitespace-nowrap">Case Manager</th>
                                <th class="whitespace-nowrap">Access Code</th>
                                <th class="whitespace-nowrap">Work Number</th>
                                <th class="whitespace-nowrap">Current Language</th>
                                <th class="whitespace-nowrap">Translated Language</th>
                                <th class="whitespace-nowrap">Original Doc</th>
                                <th class="whitespace-nowrap">Payment Status</th>
                                <th class="whitespace-nowrap">Order Status</th>
                                <th class="whitespace-nowrap">Contractor Assigned</th>
                                <th class="whitespace-nowrap">Translation File</th>
                                <th class="whitespace-nowrap">ProofReader Assigned</th>
                                <th class="whitespace-nowrap">ProofRead File</th>
                                <th class="whitespace-nowrap">Translation Rate ($/W or $/P)</th>
                                <th class="whitespace-nowrap">Translation Adjusted Rate ($)</th>
                                <th class="whitespace-nowrap">Total Words</th>
                                <th class="whitespace-nowrap">Translation Due Date</th>
                                <th class="whitespace-nowrap">Translation Type</th>
                                <th class="whitespace-nowrap">Total Translation Payment</th>
                                <th class="whitespace-nowrap">Translation Adjust Note</th>
                                <th class="whitespace-nowrap">Proofread Due Date</th>
                                <th class="whitespace-nowrap">Proofread Adjusted Rate ($/W or $/P)</th>
                                <th class="whitespace-nowrap">Proofread Total Payment</th>
                                <th class="whitespace-nowrap">Proofread Adjust Note</th>
                                <th class="whitespace-nowrap">Proofread Type</th>
                                <th class="whitespace-nowrap">Invoice</th>
                                {{-- <th class="whitespace-nowrap">Translation Status</th> --}}
                                {{-- <th class="whitespace-nowrap">Proofread Status</th> --}}

                                <th class="whitespace-nowrap">Date Received</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($orders as $order)
                            {{-- @dd($order->proofread_status) --}}

                            <tr>
                                <td class="whitespace-nowrap">
                                    <div class="flex gap-2 items-center">
                                        {{-- <a href="javascript:;" data-trigger="click"
                                            title="{{ $order->orderStatus }}" class="tooltip btn btn-primary mr-1">Show
                                            Progress</a> --}}



                                        <!-- BEGIN: Modal Toggle -->
                                        <div class="text-center">
                                            <a href="{{ route('view-edit-order', $order->id) }}"
                                                class="btn btn-primary ml-1">Edit
                                            </a>
                                        </div>
                                        <div class="text-center"> <a href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#delete-modal-preview" class="btn btn-danger">Delete</a>
                                        </div> <!-- END: Modal Toggle -->


                                    </div>
                                </td>


                                <!-- BEGIN: Modal Content -->
                                <div id="delete-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                        class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                    <div class="text-3xl mt-5">Are you sure?</div>
                                                    <div class="text-slate-500 mt-2">Do you really want to delete
                                                        this
                                                        order? <br>This process cannot
                                                        be undone.</div>
                                                </div>
                                                <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                    style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                    <button type=" button" data-tw-dismiss="modal"
                                                        class="btn btn-outline-secondary w-24 mr-1 self-center">
                                                        Cancel</button>
                                                    <form action="{{ route('destroy', $order->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger w-24">Delete</button>
                                                        <!-- END: Modal Toggle -->
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- END: Modal Content -->

                                <td class="whitespace-nowrap">
                                    @if ($order->invoiceSent == 0 && $order->want_quote == 0)
                                    <a href="{{ route('invoice.customInvoice', $order->id) }}"
                                        class="btn btn-success mr-1"> <i data-lucide="calendar"
                                            class="w-5 h-5 mr-2"></i> Send Invoice</a>
                                    @elseif($order->invoiceSent == 1 && $order->paymentStatus == 3)
                                    <a href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#header-footer-modal-preview" class="btn btn-pending">View Late
                                        Pay Request</a>
                                    {{--
                                    <a href="{{ route('approveEvidence',$order->id) }}" class="btn btn-success mr-1"> <i
                                            data-lucide="thumbs-up" class="w-5 h-5 mr-2"></i>Accept</a>
                                    <a href="{{ route('rejectEvidence',$order->id) }}" class="btn btn-danger mr-1">
                                        <i data-lucide="thumbs-down" class="w-5 h-5 mr-2"></i>Reject</a> --}}


                                    <div id="header-footer-modal-preview" class="modal" tabindex="-1"
                                        aria-hidden="true">

                                        <div class="modal-dialog">
                                            <form action="{{ route('manageLatePay') }}" method="post">
                                                @csrf
                                                @method('POST')
                                                <div class="modal-content">
                                                    <!-- BEGIN: Modal Header -->
                                                    <div class="modal-header">
                                                        <h2 class="font-medium text-base mr-auto">Manage Late
                                                            Payment
                                                        </h2>

                                                    </div> <!-- END: Modal Header -->
                                                    <!-- BEGIN: Modal Body -->
                                                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                                        <div class="col-span-12 sm:col-span-12">
                                                            <input type="hidden" name="order_id"
                                                                value="{{ $order->id }}">
                                                            <label for="modal-form-1"
                                                                class="form-label">Username</label>
                                                            <input id="modal-form-1" type="text" disabled
                                                                class="form-control mb-5"
                                                                value="{{ $order->user->name }}">
                                                            <label for="modal-form-1" class="form-label">Code</label>
                                                            <input id="modal-form-1" type="text" disabled
                                                                class="form-control" value="{{ $order->payLaterCode }}">
                                                            <div class="flex flex-col sm:flex-row mt-5">

                                                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                                                    <input id="radio-switch-5" class="form-check-input"
                                                                        type="radio" name="choice" value="1">
                                                                    <label class="form-check-label"
                                                                        for="radio-switch-5">Approve</label>
                                                                </div>
                                                                <div class="form-check mr-2 mt-2 sm:mt-0">
                                                                    <input id="radio-switch-6" class="form-check-input"
                                                                        type="radio" name="choice" value="0">
                                                                    <label class="form-check-label"
                                                                        for="radio-switch-6">Reject</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div> <!-- END: Modal Body -->
                                                    <!-- BEGIN: Modal Footer -->
                                                    <div class="modal-footer"> <button type="button"
                                                            data-tw-dismiss="modal"
                                                            class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                                        <button type="submit" class="btn btn-primary w-40">Make
                                                            Decision</button>
                                                    </div> <!-- END: Modal Footer -->
                                                </div>
                                            </form>
                                        </div>

                                    </div> <!-- END: Modal Content -->
                                    @elseif($order->want_quote == 1)
                                     <a href="{{ route('admin.showOrderSubmitQuote', $order->id) }}" class="btn btn-warning mr-1  ">Submit Quote</a>
                                    @elseif($order->invoiceSent == 1 && $order->paymentStatus == 0 &&
                                    $order->is_evidence == 1)
                                    <a href="{{ route('downloadEvidence', $order->id) }}" class="btn btn-warning mr-1">
                                        <i data-lucide="mouse-pointer" class="w-5 h-5 mr-2"></i> Download
                                        Proof</a>
                                    <a href="{{ route('approveEvidence', $order->id) }}" class="btn btn-success mr-1">
                                        <i data-lucide="thumbs-up" class="w-5 h-5"></i></a>
                                    <a href="{{ route('rejectEvidence', $order->id) }}" class="btn btn-danger mr-1">
                                        <i data-lucide="thumbs-down" class="w-5 h-5"></i></a>
                                    @elseif ($order->want_quote == 2)
                                        <button class="btn btn-warning mr-1  ">Waiting for Payment <i  data-loading-icon="three-dots" data-color="1a202c" class="w-4 h-4 ml-2"></i></button>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                                    <button class="btn btn-warning mr-1"> Waiting for Payment <i
                                            data-loading-icon="three-dots" data-color="1a202c" class="w-4 h-4 ml-2"></i>
                                    </button>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 2 &&
                                    $order->translation_status == 0 &&
                                    $order->translation_sent == 0)

                                    <a href="{{ route('view-assign-contractor', ['orderID' => $order->id]) }}"
                                        class="btn btn-pending mr-1">
                                        <i data-lucide="mail" class="w-5 h-5 mr-2"></i>Assign To Translator
                                    </a>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 0 &&
                                    $order->translation_sent == 1)
                                    <div class="btn-group">

                                        <a href="{{ route('showTranslationRequests') }}" class="btn btn-pending mr-1 ">
                                            <i data-lucide="mail" class="w-5 h-5 mr-2"></i> Track Translation
                                            Request
                                        </a>
                                        <a href="{{ route('mailToTranslator', $order->id) }}"
                                            class="btn btn-pending mr-1 "> <i data-lucide="mail"
                                                class="w-5 h-5 mr-2"></i> Mail to Translator </a>

                                    </div>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 2 &&
                                    $order->translation_status == 0 &&
                                    $order->translation_sent == 1)
                                    <div class="btn-group">

                                        <a href="{{ route('view-assign-contractor', ['orderID' => $order->id]) }}"
                                            class="btn btn-pending mr-1">
                                            <i data-lucide="mail" class="w-5 h-5 mr-2"></i>Re-Assign To
                                            Translator
                                        </a>

                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 &&
                                    $order->translation_status == 0)
                                    <a href="{{ route('view-assign-contractor', ['orderID' => $order->id]) }}"
                                        class="btn btn-pending mr-1">
                                        <i data-lucide="mail" class="w-5 h-5 mr-2"></i>Assign To Translator
                                    </a>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 1 &&
                                    $order->proofread_status == 0 &&
                                    $order->proofread_sent == 1 &&
                                    isset($order->proofReaderOrder) &&
                                    $order->proofReaderOrder->is_accepted == 1)
                                    <div class="btn-group">


                                        <a href="{{ route('view-assign-proofreader', $order->id) }}"
                                            title="Assign Proof Reader" class="btn btn-dark mr-1">
                                            <i data-lucide="user" class="w-5 h-5 mr-2"></i>
                                            Assign Proof Reader
                                        </a>
                                    </div>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 1 &&
                                    $order->proofread_status == 0)
                                    {{-- <a href="{{ route('mailToProofReader', $order->id) }}"
                                        class="btn btn-dark mr-1"><i data-lucide="mail" class="w-5 h-5 mr-2"></i>
                                        Mail to Proofreader </a>
                                    <a href="{{ route('mailOfCompletion', $order->id) }}"
                                        class="btn btn-success mr-1"><i data-lucide="mail" class="w-5 h-5 mr-2"></i>
                                        Send Translation to User </a> --}}
                                    <a href="{{ route('view-assign-proofreader', $order->id) }}"
                                        title="Assign Proof Reader" class="btn btn-dark mr-1">
                                        <i data-lucide="user" class="w-5 h-5 mr-2"></i>
                                        Assign Proof Reader
                                    </a>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 2 &&
                                    $order->translation_status == 1 &&
                                    $order->proofread_status == 0)
                                    {{-- <a href="{{ route('mailToProofReader', $order->id) }}"
                                        class="btn btn-dark mr-1"><i data-lucide="mail" class="w-5 h-5 mr-2"></i>
                                        Mail to Proofreader </a>
                                    <a href="{{ route('mailOfCompletion', $order->id) }}"
                                        class="btn btn-success mr-1"><i data-lucide="mail" class="w-5 h-5 mr-2"></i>
                                        Send Translation to User </a> --}}
                                    <a href="{{ route('view-assign-proofreader', $order->id) }}"
                                        title="Assign Proof Reader" class="btn btn-dark mr-1">
                                        <i data-lucide="user" class="w-5 h-5 mr-2"></i>
                                        Assign Proof Reader
                                    </a>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 1 &&
                                    $order->proofread_status == 1)
                                    <a href="{{ route('mailOfCompletion', $order->id) }}"
                                        class="btn btn-success mr-1"><i data-lucide="mail" class="w-5 h-5 mr-2"></i>
                                        Send Translation to User </a>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 1 &&
                                    $order->proofread_status == 1)
                                    <a href="{{ route('mailOfCompletion', $order->id) }}"
                                        class="btn btn-success mr-1"><i data-lucide="mail" class="w-5 h-5 mr-2"></i>
                                        Send Translation to User </a>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap">{{ $order->user->name }}</td>
                                <td class="whitespace-nowrap">{{ $order->user->email }}</td>
                                <td class="whitespace-nowrap badge badge-success">{{ $order->orderStatus }}</td>
                                @if($order->message)
                                <td class="whitespace-nowrap" title="{{$order->message}}">
                                    <i data-lucide="message-square" class="w-5 h-5 mr-2" > </i>
                                    </td>
                                @else
                                <td class="whitespace-nowrap">-</td>
                                @endif
                                <td class="whitespace-nowrap">
                                    {{ $order->casemanager != '' ? $order->casemanager : 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $order->access_code != '' ? $order->access_code : 'N/A' }}
                                </td>

                                <td class="whitespace-nowrap">{{ $order->worknumber }}</td>
                                <td class="whitespace-nowrap">{{ $order->language1 }}</td>
                                <td class="whitespace-nowrap">{{ $order->language2 }}</td>
                                <td class="whitespace-nowrap"><a href="{{ route('downloadFiles', $order->id) }}"
                                        class="btn btn-warning mr-1">
                                        <i data-lucide="download" class="w-5 h-5"></i> </a></td>
                                @if ($order->user->role_id == 1 || $order->user->role_id == 2)
                                <td class="whitespace-nowrap"><button
                                        class="btn btn-rounded-warning w-24 mr-1">Institute</button></td>
                                @elseif ($order->paymentStatus == 1)
                                <td class="whitespace-nowrap"><button
                                        class="btn btn-rounded-success w-24 mr-1">Paid</button></td>
                                @elseif ($order->paymentStatus == 2)
                                <td class="whitespace-nowrap"><button class="btn btn-rounded-warning w-28 mr-1">Deferred
                                        Payment</button></td>
                                @else
                                <td class="whitespace-nowrap"><button
                                        class="btn btn-rounded-pending w-24 mr-1">Pending</button></td>
                                @endif
                                <td class="whitespace-nowrap">
                                    @if ($order->invoiceSent == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 3 &&
                                    $order->payLaterCode != null)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">10%</div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0 &&
                                    $order->is_evidence == 1)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">30%</div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">25%</div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 2)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-2/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">50%</div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 &&
                                    $order->translation_status == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-2/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">50%</div>
                                    </div>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 0 &&
                                    $order->translation_sent == 1)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-2/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">60%</div>
                                    </div>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 1 &&
                                    $order->proofread_status == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-3/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">75%</div>
                                    </div>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 1 &&
                                    $order->proofread_status == 0 &&
                                    $order->proofread_sent == 1)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-3/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">85%</div>
                                    </div>
                                    @elseif (
                                    $order->invoiceSent == 1 &&
                                    $order->paymentStatus == 1 &&
                                    $order->translation_status == 1 &&
                                    $order->proofread_status == 1)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-4/4" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100">100%</div>
                                    </div>
                                    @endif

                                </td>
                                {{-- @isset($order->contractorOrder) --}}
                                @if (isset($order->contractorOrder) &&
                                $order->contractorOrder->contractor->name != '' &&
                                $order->contractorOrder->is_accepted == 1)
                                <td>{{ $order->contractorOrder->contractor->name }}</td>
                                @else
                                <td>N/A</td>
                                @endif
                                @if (isset($order->contractorOrder) && $order->contractorOrder->file_name != '')
                                <td>
                                    <a class="btn" title="Download Translation"
                                        href="{{ route('download-translation-file', $order->id) }}">
                                        Download
                                    </a>
                                </td>
                                @else
                                <td>N/A</td>
                                @endif
                                @if (isset($order->proofReaderOrder) &&
                                $order->proofReaderOrder->contractor->name != '' &&
                                $order->proofReaderOrder->is_accepted == 1)
                                <td>{{ $order->proofReaderOrder->contractor->name }}</td>
                                @else
                                <td>N/A</td>
                                @endif
                                @if (
                                $order->invoiceSent == 1 &&
                                $order->paymentStatus == 2 &&
                                $order->translation_status == 1 &&
                                $order->proofread_status == 1)
                                <td>
                                    <a class="btn" title="Download ProofRead File"
                                        href="{{ route('download-proof-read-file', $order->id) }}">
                                        Download
                                    </a>
                                </td>
                                @elseif(
                                $order->invoiceSent == 1 &&
                                $order->paymentStatus == 1 &&
                                $order->translation_status == 1 &&
                                $order->proofread_status == 1)
                                <td>
                                    <a class="btn" title="Download ProofRead File"
                                        href="{{ route('download-proof-read-file', $order->id) }}">
                                        Download
                                    </a>
                                </td>
                                @else
                                <td>N/A</td>
                                @endif
                                @if($order->contractorOrder && $order->contractorOrder->is_accepted == 1)
                                    <td>${{$order->contractorOrder->contractor->translation_rate}}</td>
                                    <td>${{$order->contractorOrder->rate}}</td>
                                    <td>{{$order->contractorOrder->total_words}}</td>
                                    <td>{{$order->contractorOrder->translation_due_date}}</td>
                                    <td>{{$order->contractorOrder->translation_type}}</td>
                                    <td>${{$order->contractorOrder->total_payment}}</td>
                                    <td title="{{$order->contractorOrder->message}}"><i data-lucide="message-square" class="w-5 h-5 mr-2" > </i></td>
                                @else
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                @endif
                                @if($order->proofReaderOrder)
                                    <td>{{$order->proofReaderOrder->proof_read_due_date}}</td>
                                    <td>{{$order->proofReaderOrder->rate}}</td>
                                    <td>{{$order->proofReaderOrder->total_payment}}</td>
                                    
                                    <td title="{{$order->proofReaderOrder->feedback}}">
                                    <i data-lucide="message-square" class="w-5 h-5 mr-2" > </i>
                                    </td>
                                    <td>{{$order->proofReaderOrder->proofread_type}}</td>
                                @else
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                @endif
                                @if(isset($order->invoice) && $order->user->role_id == 1 && $order->invoiceSent == 1)
                                    <td><a href="
                                        {{route('view-invoice',['id'=>$order->invoice->id])}}
                                        " class="btn btn-secondary m-2">View Invoice</a></td>
                                @else
                                    <td>N/A</td>
                                @endif
                                <td class="whitespace-nowrap">
                                    {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($order->created_at,
                                    request()->ip()) }}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
 $(document).ready(function() {
                var table = $('#ordersTable').DataTable({
                    ordering: true,
                    info: true,
                    paging: true
                });

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var isPendingChecked = $('#checkbox-status-pending').is(':checked');
                        var isCompletedChecked = $('#checkbox-status-completed').is(':checked');
                        var isCancelledChecked = $('#checkbox-status-cancelled').is(':checked');
                        var isInvoicePendingChecked = $('#checkbox-status-invoice-pending').is(':checked');

                        if (isPendingChecked && data[4] == 'Translation Pending') {
                            return true;
                        } else if (isCompletedChecked && data[4] == 'Completed') {
                            return true;
                        } else if (isCancelledChecked && data[4] == 'Cancelled') {
                            return true;
                        } else if (isInvoicePendingChecked && data[4] == 'Invoice Pending') {
                            return true;
                        }


                        return false;
                    }
                );

                $('.status-filter').on('change', function() {
                    table.draw();
                });

                // Generate a checkbox for each column in the dropdown
                table.columns().every(function() {
                    var column = this;

                    var checkbox = $(
                        '<li><div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"><input checked id="checkbox-item-' +
                        column.index() +
                        '" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500 toggle-vis" data-column="' +
                        column.index() + '"><label for="checkbox-item-' + column.index() +
                        '" class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">' +
                        $(column.header()).text() + '</label></div></li>');
                    checkbox.appendTo('#dropdownList ul');
                });

                $("#dropdownBgHoverButtonStatus").click(function() {
                    $('#dropdownListStatus').toggle();
                });

                // Hide/show the column when its checkbox is toggled
                $('input.toggle-vis').on('change', function(e) {
                    e.preventDefault();
                    var column = table.column($(this).attr('data-column'));
                    column.visible(!column.visible());
                });

                // Toggle dropdown visibility for column filter
                $("#dropdownBgHoverButton").click(function() {
                    $('#dropdownList').toggle();
                });

                var groups = {
                    'User Info': [2,3],
                    'Order Info': [4,5,6,7,8,9,10,11,12,13],
                    'Translator Info': [14,15,18,19,20,21,22,23,24],
                    'ProofRead Info': [16, 17,25,26,27,28,29]
                }

                for (var groupName in groups) {
                    var checkbox = $(
                        '<li><div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"><input checked id="checkbox-group-item-' +
                        groupName +
                        '" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 toggle-vis-group" data-group="' +
                        groupName + '"><label for="checkbox-group-item-' + groupName +
                        '" class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">' +
                        groupName + '</label></div></li>');
                    checkbox.appendTo('#dropdownListGroup ul');
                }

                $('input.toggle-vis-group').on('change', function(e) {
                    e.preventDefault();
                    var group = $(this).attr('data-group');
                    var visible = $(this).is(':checked');
                    groups[group].forEach(function(index) {
                        table.column(index).visible(visible);
                    });
                });

                // Toggle dropdown visibility for group filter
                $("#dropdownBgHoverButtonGroup").click(function() {
                    $('#dropdownListGroup').toggle();
                });
            });
</script>
{{-- <script>
    $(document).ready( function () {
            $('#pendingOrders').DataTable({
                info: false,
                paging: false
            });
        } );
</script> --}}
@endsection