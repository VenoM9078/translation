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

        .sticky-column-1,
        .sticky-column-2 {
            position: sticky !important;
            /* left: 0; */
            background-color: white;
            /* Adjust as per your need */
            z-index: 1000;
            /* Adjust as per your need */
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

    </div>

    <div class="intro-y flex items-center h-10 mb-5 mt-2">
        <h2 class="text-lg font-medium truncate ml-2 mr-5">
            Translation Orders
        </h2>
    </div>
    <hr style="margin-bottom: 30px;">
    <!-- BEGIN: Data List -->
    {{-- DropDown --}}
    @if (isset($message))
        <div class="alert alert-success mt-3 mb-3">
            <ul>
                <li>{{ $message }}</li>
            </ul>
        </div>
    @endif
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
                    {{-- hiding cancelled status --}}
                    <li style="display: none">
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
                                class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Invoice
                                Pending</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input checked id="checkbox-status-invoice-completed" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 status-filter"
                                data-status="pending">
                            <label for="checkbox-status-invoice-pending"
                                class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Invoice
                                Sent</label>
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
                                    <th class="whitespace-nowrap sticky-column-1">Actions</th>
                                    <th class="whitespace-nowrap sticky-column-2 " style="display: none">Next Step</th>
                                    <th class="whitespace-nowrap">WO#</th>
                                    <th class="whitespace-nowrap">Institute</th>
                                    <th class="whitespace-nowrap">Requester</th>
                                    <th class="whitespace-nowrap">Due Date</th>
                                    <th class="whitespace-nowrap" style="display: none">Email</th>
                                    <th class="whitespace-nowrap">Order Status</th>
                                    <th class="whitespace-nowrap">Quote</th>
                                    <th class="whitespace-nowrap">Order Note</th>
                                    <th class="whitespace-nowrap">Source Language</th>
                                    <th class="whitespace-nowrap">Translated Language</th>
                                    <th class="whitespace-nowrap">C. Type</th>
                                    <th class="whitespace-nowrap">C. Unit</th>
                                    <th class="whitespace-nowrap">C. Rate</th>
                                    <th class="whitespace-nowrap">C. Adjust</th>
                                    <th class="whitespace-nowrap">C. Fee</th>
                                    <th class="whitespace-nowrap">C. Adjust Note</th>
                                    <th class="whitespace-nowrap">C. Paid</th>
                                    <th class="whitespace-nowrap">Translator</th>
                                    <th class="whitespace-nowrap">Translation Due Date</th>
                                    <th class="whitespace-nowrap">Translated Document</th>
                                    <th class="whitespace-nowrap">Translator Message</th>
                                    <th class="whitespace-nowrap">T.Type</th>
                                    <th class="whitespace-nowrap">T.Unit</th>
                                    <th class="whitespace-nowrap">T. Rate ($/W or $/P)</th>
                                    <th class="whitespace-nowrap">T. Adjust ($)</th>
                                    <th class="whitespace-nowrap">T. Fee ($)</th>
                                    <th class="whitespace-nowrap">T. Adjust Note</th>
                                    <th class="whitespace-nowrap">T. Paid</th>
                                    <th class="whitespace-nowrap">ProofReader</th>
                                    <th class="whitespace-nowrap">Proofread Due Date</th>
                                    <th class="whitespace-nowrap">ProofRead Document</th>
                                    <th class="whitespace-nowrap">ProofReader Message</th>
                                    <th class="whitespace-nowrap">P. Type</th>
                                    <th class="whitespace-nowrap">P. Unit</th>
                                    <th class="whitespace-nowrap">P. Rate ($/W or $/P)</th>
                                    <th class="whitespace-nowrap">P. Adjust ($)</th>
                                    <th class="whitespace-nowrap">P. Fee ($)</th>
                                    <th class="whitespace-nowrap">P. Adjust Note</th>
                                    <th class="whitespace-nowrap">P. Paid</th>
                                    <th class="whitespace-nowrap">Final Doc</th>
                                    <th class="whitespace-nowrap">Invoice</th>
                                    <th class="whitespace-nowrap">Date Received</th>

                                </tr>
                            </thead>

                            <tbody>
                                {{-- @dd($pendingOrders) --}}
                                @foreach ($pendingOrders as $key => $order)
                                    {{-- @dd($order->proofread_status) --}}
                                    <tr>
                                        <td class="whitespace-nowrap">
                                            <div class="flex gap-1 items-center">

                                                <!-- BEGIN: Modal Toggle -->
                                                <div class="text-center">
                                                    <a href="{{ route('admin.show-order', $order->id) }}"
                                                        class="btn btn-primary">
                                                        <svg class="w-5 h-5 text-white mx-auto"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                                        </svg>

                                                    </a>
                                                </div>
                                                <div class="text-center"> <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#track-modal-preview{{ $order->id }}"
                                                        title="Track" class="btn btn-success">
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
                                                <div class="text-center">
                                                    <a href="{{ route('admin.view-edit-order', $order->id) }}"
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
                                                <div class="text-center">
                                                    <a href="{{ route('assign-proofread-translator', $order->id) }}"
                                                        class="btn bg-green-700" title="Assign">
                                                        <svg class="w-5 h-5 text-white mx-auto"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                                        </svg>

                                                    </a>
                                                </div>
                                                <div class="text-center"> <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#delete-modal-preview{{ $order->id }}"
                                                        class="btn btn-danger">
                                                        <svg class="w-5 h-5 text-white mx-auto"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>

                                                    </a>
                                                </div> <!-- END: Modal Toggle -->
                                                @if ($order->contractorOrder == null && $order->proofReaderOrder == null)
                                                    <div class="text-center">
                                                        <form action="{{ route('admin-cancelOrder') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="order_id"
                                                                value="{{ $order->id }}">
                                                            <button type="submit" class="btn btn-danger bg-red-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="2.5"
                                                                    stroke="currentColor" class="w-5 h-5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                                <div class="text-center">
                                                    <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#upload-modal-preview-{{ $key }}"
                                                        class="btn btn-pending"> <svg xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                                                        </svg>
                                                    </a>
                                                    {{-- Modal --}}
                                                    @include('utils.order-upload-modal', [
                                                        'key' => $key,
                                                        'order' => $order,
                                                    ])
                                                    @if (
                                                        $order->invoiceSent == 1 &&
                                                            ($order->paymentStatus == 1 || $order->paymentStatus == 2) &&
                                                            $order->translation_status == 1 &&
                                                            $order->proofread_status == 1)
                                                        <a href="{{ route('mailOfCompletion', $order->id) }}"
                                                            class="btn btn-success mr-1">
                                                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M4.5 12.75l6 6 9-13.5" />
                                                            </svg>

                                                            Mark Completed </a>
                                                    @elseif($order->want_quote == 1 && $order->translation_status == 0)

                                                    @elseif ($order->invoiceSent == 0 && $order->is_order_quote_accepted == 1 && $order->user->role_id == 0)
                                                        <a href="{{ route('invoice.customInvoice', $order->id) }}"
                                                            class="btn btn-success mr-1">
                                                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>

                                                            Send Invoice</a>
                                                    @elseif($order->invoiceSent == 1 && $order->paymentStatus == 3 && $order->payLaterCode != null)
                                                        <a href="javascript:;" data-tw-toggle="modal"
                                                            data-tw-target="#header-footer-modal-preview"
                                                            class="btn btn-pending">View Late
                                                            Pay Request</a>
                                                        <div id="header-footer-modal-preview" class="modal"
                                                            tabindex="-1" aria-hidden="true">

                                                            <div class="modal-dialog">
                                                                <form action="{{ route('manageLatePay') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <div class="modal-content">
                                                                        <!-- BEGIN: Modal Header -->
                                                                        <div class="modal-header">
                                                                            <h2 class="font-medium text-base mr-auto">
                                                                                Manage Late
                                                                                Payment
                                                                            </h2>

                                                                        </div> <!-- END: Modal Header -->
                                                                        <!-- BEGIN: Modal Body -->
                                                                        <div
                                                                            class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                                                            <div class="col-span-12 sm:col-span-12">
                                                                                <input type="hidden" name="order_id"
                                                                                    value="{{ $order->id }}">
                                                                                <label for="modal-form-1"
                                                                                    class="form-label">Username</label>
                                                                                <input id="modal-form-1" type="text"
                                                                                    disabled class="form-control mb-5"
                                                                                    value="{{ $order->user->name }}">
                                                                                <label for="modal-form-1"
                                                                                    class="form-label">Code</label>
                                                                                <input id="modal-form-1" type="text"
                                                                                    disabled class="form-control"
                                                                                    value="{{ $order->payLaterCode }}">
                                                                                <div
                                                                                    class="flex flex-col sm:flex-row mt-5">

                                                                                    <div
                                                                                        class="form-check mr-2 mt-2 sm:mt-0">
                                                                                        <input id="radio-switch-5"
                                                                                            class="form-check-input"
                                                                                            type="radio" name="choice"
                                                                                            value="1">
                                                                                        <label class="form-check-label"
                                                                                            for="radio-switch-5">Approve</label>
                                                                                    </div>
                                                                                    <div
                                                                                        class="form-check mr-2 mt-2 sm:mt-0">
                                                                                        <input id="radio-switch-6"
                                                                                            class="form-check-input"
                                                                                            type="radio" name="choice"
                                                                                            value="0">
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
                                                                            <button type="submit"
                                                                                class="btn btn-primary w-40">Make
                                                                                Decision</button>
                                                                        </div> <!-- END: Modal Footer -->
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div> <!-- END: Modal Content -->
                                                    @elseif (
                                                        $order->invoiceSent == 1 &&
                                                            $order->paymentStatus == 1 &&
                                                            $order->translation_status == 1 &&
                                                            $order->proofread_status == 1)
                                                        <a href="{{ route('mailOfCompletion', $order->id) }}"
                                                            class="btn btn-success mr-1">
                                                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M4.5 12.75l6 6 9-13.5" />
                                                            </svg>
                                                            Mark Completed</a>
                                                    @endif
                                                </div>

                                            </div>
                                        </td>
                                        <div id="track-modal-preview{{ $order->id }}" class="modal" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body p-0">
                                                        <div class="p-5 text-center"> <i data-lucide="target"
                                                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                                                            <div class="text-3xl mt-5">Track Order</div>
                                                        </div>
                                                        <div class="intro-y box py-5 mt-2 mx-auto">
                                                            <div class="loader text-center" role="status"
                                                                id="order-loader-{{ $order->id }}"
                                                                style="display: none">
                                                                <svg aria-hidden="true"
                                                                    class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                                                    viewBox="0 0 100 101" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                                        fill="currentColor" />
                                                                    <path
                                                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                                        fill="currentFill" />
                                                                </svg>
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- END: Modal Content -->
                                        <!-- BEGIN: Modal Content -->
                                        <div id="delete-modal-preview{{ $order->id }}" class="modal" tabindex="-1"
                                            aria-hidden="true">
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
                                                            <form action="{{ route('destroy', $order->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger bg-red-500 w-24">Delete</button>
                                                                <!-- END: Modal Toggle -->
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- END: Modal Content -->

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
                                                            @if ($order->quote_filename != null)
                                                                <div class="w-full text-center">
                                                                    <a class="btn btn-success border-indigo-600"
                                                                        title="Download Quote submitted by Admin"
                                                                        href="{{ route('downloadQuote', $order->id) }}">Download
                                                                        Quote File</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- END: Modal Content -->

                                        <td class="whitespace-nowrap" style="display: none">
                                            @if ($order->invoiceSent == 0 && $order->want_quote == 0)
                                                <a href="{{ route('invoice.customInvoice', $order->id) }}"
                                                    class="btn btn-success mr-1"> <i data-lucide="calendar"
                                                        class="w-5 h-5 mr-2"></i> Send Invoice</a>
                                            @elseif($order->invoiceSent == 1 && $order->paymentStatus == 3 && $order->payLaterCode != null)
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#header-footer-modal-preview"
                                                    class="btn btn-pending">View Late
                                                    Pay Request</a>
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
                                                                        <label for="modal-form-1"
                                                                            class="form-label">Code</label>
                                                                        <input id="modal-form-1" type="text" disabled
                                                                            class="form-control"
                                                                            value="{{ $order->payLaterCode }}">
                                                                        <div class="flex flex-col sm:flex-row mt-5">

                                                                            <div class="form-check mr-2 mt-2 sm:mt-0">
                                                                                <input id="radio-switch-5"
                                                                                    class="form-check-input"
                                                                                    type="radio" name="choice"
                                                                                    value="1">
                                                                                <label class="form-check-label"
                                                                                    for="radio-switch-5">Approve</label>
                                                                            </div>
                                                                            <div class="form-check mr-2 mt-2 sm:mt-0">
                                                                                <input id="radio-switch-6"
                                                                                    class="form-check-input"
                                                                                    type="radio" name="choice"
                                                                                    value="0">
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
                                                                    <button type="submit"
                                                                        class="btn btn-primary w-40">Make
                                                                        Decision</button>
                                                                </div> <!-- END: Modal Footer -->
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div> <!-- END: Modal Content -->
                                            @elseif($order->want_quote == 1)
                                                <a href="{{ route('admin.showOrderSubmitQuote', $order->id) }}"
                                                    class="btn btn-warning mr-1  ">Quote</a>
                                            @elseif($order->invoiceSent == 1 && $order->paymentStatus == 0 && $order->is_evidence == 1)
                                                <a href="{{ route('downloadEvidence', $order->id) }}"
                                                    class="btn btn-warning mr-1">
                                                    <i data-lucide="mouse-pointer" class="w-5 h-5 mr-2"></i> Download
                                                    Proof</a>
                                                <a href="{{ route('approveEvidence', $order->id) }}"
                                                    class="btn btn-success mr-1">
                                                    <i data-lucide="thumbs-up" class="w-5 h-5"></i></a>
                                                <a href="{{ route('rejectEvidence', $order->id) }}"
                                                    class="btn btn-danger mr-1">
                                                    <i data-lucide="thumbs-down" class="w-5 h-5"></i></a>
                                            @elseif ($order->want_quote == 2 && 1 == 2)
                                                <button class="btn btn-warning mr-1  ">Waiting for Payment
                                                    <svg class="w-4 h-4 ml-2" aria-hidden="true"
                                                        class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                                                        viewBox="0 0 100 101" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                            fill="currentFill" />
                                                    </svg>
                                                </button>
                                            @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0 && 1 == 2)
                                                <button class="btn btn-warning mr-1"> Waiting for Payment
                                                    <svg class="w-4 h-4 ml-2" aria-hidden="true"
                                                        class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                                                        viewBox="0 0 100 101" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                            fill="currentFill" />
                                                    </svg>
                                                </button>
                                            @elseif (
                                                $order->invoiceSent == 1 &&
                                                    $order->paymentStatus == 1 &&
                                                    $order->translation_status == 1 &&
                                                    $order->proofread_status == 1)
                                                <a href="{{ route('mailOfCompletion', $order->id) }}"
                                                    class="btn btn-success mr-1"><i data-lucide="mail"
                                                        class="w-5 h-5 mr-2"></i>
                                                    Send Translation to User </a>
                                            @elseif (
                                                $order->invoiceSent == 1 &&
                                                    $order->paymentStatus == 1 &&
                                                    $order->translation_status == 1 &&
                                                    $order->proofread_status == 1)
                                                <a href="{{ route('mailOfCompletion', $order->id) }}"
                                                    class="btn btn-success mr-1"><i data-lucide="mail"
                                                        class="w-5 h-5 mr-2"></i>
                                                    Send Translation to User </a>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap">{{ $order->worknumber }}</td>
                                        <td class="whitespace-nowrap">
                                            @if ($order->added_by_institute_user)
                                                @if ($order->user->role_id == 1 && count($order->user->institute) > 0)
                                                    @forelse ($order->user->institute as $institute)
                                                        {{--
                                <td class="whitespace-nowrap"> --}}
                                                        {{ $institute->name }}
                                                        {{-- </td> --}}
                                                    @empty
                                                        {{-- <td class="whitespace-nowrap"> --}}
                                                        N/A
                                                        {{-- </td> --}}
                                                    @endforelse
                                                @elseif($order->user->role_id == 2)
                                                    @if (isset($order->user->institute_managed))
                                                        {{-- <td class="whitespace-nowrap"> --}}
                                                        {{ $order->user->institute_managed->name }}
                                                        {{-- </td> --}}
                                                    @else
                                                        {{-- <td class="whitespace-nowrap"> --}}
                                                        N/A
                                                        {{-- </td> --}}
                                                    @endif
                                                @endif
                                            @else
                                                {{-- <td class="whitespace-nowrap"> --}}
                                                N/A
                                                {{-- </td> --}}
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap">{{ $order->user->name }}</td>
                                        <td class="whitespace-nowrap">{{ $order->due_date }}</td>
                                        <td class="whitespace-nowrap" style="display: none">{{ $order->user->email }}
                                        </td>
                                        <td class="whitespace-nowrap badge badge-success">
                                            @include('utils.order-status-column', ['order' => $order])
                                        </td>
                                        <td class="whitespace-nowrap badge badge-success">
                                            @if ($order->quote_filename != null)
                                                <div class="w-full text-center">
                                                    <a class="btn btn-success border-indigo-600"
                                                        title="Download Quote submitted by Admin"
                                                        href="{{ route('downloadQuote', $order->id) }}">Download Quote
                                                        File</a>
                                                </div>
                                            @else
                                                <span class="bg-info p-2">N/A</span>
                                            @endif
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
                                        @endif

                                        <td class="whitespace-nowrap">{{ $order->language1 }}</td>
                                        <td class="whitespace-nowrap">{{ $order->language2 }}</td>
                                        <td class="whitespace-nowrap">{{ $order->c_type }}</td>
                                        {{-- @dd($order->c_type) --}}
                                        <td class="whitespace-nowrap">{{ $order->c_unit }}</td>
                                        <td class="whitespace-nowrap">{{ $order->c_rate }}</td>
                                        <td class="whitespace-nowrap">{{ $order->c_adjust }}</td>
                                        <td class="whitespace-nowrap">{{ $order->c_fee }}</td>
                                        <td class="whitespace-nowrap">{{ $order->c_adjust_note }}</td>
                                        <td class="whitespace-nowrap">{{ $order->c_paid ? 'Yes' : 'No' }}</td>


                                        {{-- @isset($order->contractorOrder) --}}
                                        <td class="whitespace-nowrap">
                                            @if (isset($order->contractorOrder) &&
                                                    $order->contractorOrder->contractor != null &&
                                                    $order->contractorOrder->contractor->name != '' &&
                                                    $order->contractorOrder->is_accepted == 1)
                                                {{ $order->contractorOrder->contractor->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        @if ($order->contractorOrder && $order->contractorOrder->is_accepted == 1 && $order->contractorOrder->contractor != null)
                                            <td>{{ $order->contractorOrder->translation_due_date ?? '-' }}</td>
                                        @endif
                                        @if (isset($order->contractorOrder) && $order->contractorOrder->file_name != '' ||
                                        (isset($order->contractorOrder) && $order->contractorOrder->added_by_admin == 1)
                                        )
                                            <td>
                                                <a class="btn" title="Download Translation"
                                                    href="{{ route('download-translation-file', $order->id) }}">
                                                    Download
                                                </a>
                                            </td>
                                        @else
                                            <td> No File </td>
                                        @endif
                                        @if ($order->contractorOrder && $order->contractorOrder->is_accepted == 1 && $order->contractorOrder->contractor != null)
                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#translator-message-modal-preview{{ $order->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>
                                            <div id="translator-message-modal-preview{{ $order->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">Translator Message</div>
                                                                <div class="w-full text-left">
                                                                    <label for="order-form-21" class="form-label">Client
                                                                        Message:</label>
                                                                    <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $order->contractorOrder->message }}</textarea>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            <td>{{ $order->contractorOrder->translation_type ?? '-' }}</td>
                                            <td>{{ $order->contractorOrder->translator_unit ?? '-' }} </td>
                                            <td>${{ $order->contractorOrder->contractor->translation_rate ?? '-' }}</td>
                                            <td>${{ $order->contractorOrder->translator_adjust ?? '-' }}</td>
                                            <td>${{ $order->contractorOrder->total_payment ?? '-' }}</td>
                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#t-adjust-note-modal-preview{{ $order->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>
                                            <div id="t-adjust-note-modal-preview{{ $order->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">Translator Adjust Note
                                                                </div>
                                                                <div class="w-full text-left">
                                                                    <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $order->contractorOrder->translator_adjust_note }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            <td class="whitespace-nowrap">{{ $order->contractorOrder->translator_paid }}
                                            </td>
                                        @else
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                        @endif
                                        <td class="whitespace-nowrap">
                                            @if (isset($order->proofReaderOrder))
                                                @if (isset($order->proofReaderOrder->contractor))
                                                    {{ $order->proofReaderOrder->contractor->name }}
                                                @else
                                                    -
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        @if ($order->proofReaderOrder)
                                            <td>{{ $order->proofReaderOrder->proof_read_due_date }}</td>
                                            @if (
                                                ($order->invoiceSent == 1 &&
                                                    $order->paymentStatus == 2 &&
                                                    $order->translation_status == 1 &&
                                                    $order->proofread_status == 1) ||
                                                    (isset($order->proofReaderOrder) &&
                                                        $order->proofReaderOrder->added_by_admin == 1 &&
                                                        $order->proofReaderOrder->file_name != ''))
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
                                                <td> </td>
                                            @endif
                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#proofread-message-modal-preview{{ $order->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>
                                            <div id="proofread-message-modal-preview{{ $order->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">ProofReader Message</div>
                                                                <div class="w-full text-left">
                                                                    <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $order->proofReaderOrder->message }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            <td class="whitespace-nowrap">{{ $order->proofReaderOrder->proofread_type }}
                                            </td>
                                            <td class="whitespace-nowrap">{{ $order->proofReaderOrder->p_unit }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ $order->proofReaderOrder->contractor->proofreader_rate ?? '' }}</td>
                                            <td class="whitespace-nowrap">{{ $order->proofReaderOrder->p_adjust }}</td>
                                            <td class="whitespace-nowrap">{{ $order->proofReaderOrder->total_payment }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#proofread-adj-modal-preview{{ $order->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>
                                            <div id="proofread-adj-modal-preview{{ $order->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">ProofReader Adjust Note
                                                                </div>
                                                                <div class="w-full text-left">
                                                                    <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $order->proofReaderOrder->proof_read_adjust_note }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            <td>{{ $order->proofReaderOrder->proof_read_paid == 1 ? 'Yes' : 'No' }}</td>
                                        @else
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                            <td class="whitespace-nowrap">-</td>
                                        @endif
                                        <td class="whitespace-nowrap">
                                            @if ($order->completed == 1 && isset($order->completedRequest))
                                                <a href="{{ route('downloadTranslatedFiles', $order->id) }}"
                                                    title="Download Final Document" class="btn btn-warning mr-1">

                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                    </svg>

                                                </a>
                                            @else
                                                <span>N/A</span>
                                            @endif
                                        </td>
                                        @if (isset($order->invoice) && $order->user->role_id == 1 && $order->invoiceSent == 1)
                                            <td><a href="  {{ route('view-invoice', ['id' => $order->invoice->id]) }} "
                                                    class="btn btn-secondary m-2">View Invoice</a></td>
                                        @else
                                            <td class="whitespace-nowrap"> </td>
                                        @endif
                                        <td class="whitespace-nowrap">
                                            {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($order->created_at, request()->ip()) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                    <div class="container m-2 flex justify-end">
                        {{ $pendingOrders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    {{-- </div> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-html5-2.3.6/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <!-- HTML5 and print buttons -->
    <!-- Buttons -->

    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
        // $(document).ready(function() {
        var table = $('#ordersTable').DataTable({
            dom: 'Bfrti',
            buttons: [{
                    extend: 'csv',
                    exportOptions: {
                        columns: ':gt(1)'
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':gt(1)'
                    }
                },
            ],
            scrollX: true,
            scrollCollapse: true,
            ordering: false,
            info: false,
            paging: false,
            lengthChange: false,
        });
        // });
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var isPendingChecked = $('#checkbox-status-pending').is(':checked');
                var isCompletedChecked = $('#checkbox-status-completed').is(':checked');
                var isCancelledChecked = $('#checkbox-status-cancelled').is(':checked');
                var isInvoicePendingChecked = $('#checkbox-status-invoice-pending').is(':checked');
                var isInvoiceCompletedChecked = $('#checkbox-status-invoice-completed').is(':checked');

                if (isPendingChecked && data[4] == 'Translation Pending') {
                    return true;
                } else if (isCompletedChecked && data[4] == 'Completed') {
                    return true;
                } else if (isCancelledChecked && data[4] == 'Cancelled') {
                    return true;
                } else if (isInvoicePendingChecked && data[4] == 'Invoice Pending') {
                    return true;
                } else if (isInvoiceCompletedChecked && data[4] == 'Invoice Sent') {
                    return true;
                } else {
                    return true;
                }


                return false;
            }
        );

        $('.status-filter').on('change', function() {
            table.draw();
        });

        table.on('draw.dt', function() {
            // Define the columns to be sticky
            var stickyColumns = [0, 1];

            var leftPosition = 0;

            // Loop through the columns
            for (var i = 0; i < stickyColumns.length; i++) {
                var column = table.column(stickyColumns[i]);

                // Add the CSS class to the header and cells
                $(column.header()).addClass('sticky-column-' + (i + 1));
                $(column.nodes()).addClass('sticky-column-' + (i + 1));

                // Calculate the width of the column
                // var columnWidth = $(column.nodes()).outerWidth();
                var columnWidth = $('.sticky-column-' + (i + 1)).first().outerWidth();
                // Set the left position of the column
                $('.sticky-column-' + (i + 1)).css({
                    left: leftPosition + "px",
                    zIndex: 1000
                });

                // Update the left position for the next column
                leftPosition += columnWidth;
            }
        }).draw();

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
            'User Info': [2, 3],
            'Order Info': [4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
            'Translator Info': [14, 15, 18, 19, 20, 21, 22, 23, 24],
            'ProofRead Info': [16, 17, 25, 26, 27, 28, 29]
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
        // });

        // $('.btn.btn-success').on('click', function() {
        //     var orderId = $(this).data('tw-target').replace('#track-modal-preview', '');
        //     console.log("Clicked Track ", orderId);
        //     $.get('/order/' + orderId + '/track', function(data) {
        //         $('.intro-y.box.py-10.mt-5').html(data);
        //     });
        // });
        $(document).on('click', '.btn.btn-success', function() {
            var orderId = $(this).data('tw-target').replace('#track-modal-preview', '');
            console.log("Clicked Track ", orderId);
            $('#order-loader-' + orderId).show();
            $.get('/order/' + orderId + '/track', function(data) {
                $('#order-loader-' + orderId).hide();
                $('.intro-y.box.py-5.mt-2').html(data);
            });
        });
    </script>
@endsection
