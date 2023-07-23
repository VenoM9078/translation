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

        .sticky-column-1,
        .sticky-column-2 {
            position: sticky !important;
            /* left: 0; */
            background-color: white;
            /* Adjust as per your need */
            z-index: 1000;
            /* Adjust as per your need */
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

    {{--
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-html5-2.3.6/datatables.min.css" rel="stylesheet" />
--}}
    {{--
<link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" /> --}}
    <!-- Buttons CSS -->
    {{--
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" />
--}}
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                Interpretation Orders
            </h2>
        </div>
        {{-- DropDown --}}
        @if (isset($success))
            <div class="alert alert-success mt-3 mb-3">
                <ul>
                    <li>{{ $success }}</li>
                </ul>
            </div>
        @endif
        <div class="flex justify-end gap-4">
            <div class="dropdown-container  relative inline-block my-2">
                @include('utils.limit-data-dropdown', ['route' => 'admin.ongoingInterpretations'])
            </div>
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
                        {{-- <div class="container">
                        <a href="{{ route('table-export', ['model' => 'interpretation']) }}"
                            class="btn btn-primary">Export</a>
                    </div> --}}
                        <div class="overflow-x-auto">
                            <table id="myinterpretationsTable" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap text-center sticky-column-1">Possible Action</th>
                                        <th class="whitespace-nowrap w-40 px-12 sticky-column-1">Status
                                        </th>
                                        <th class="whitespace-nowrap text-center" style="display: none">Interpretation
                                            Status</th>
                                        <th class="whitespace-nowrap text-center">WO#</th>
                                        <th class="whitespace-nowrap text-center">Institute</th>
                                        <th class="whitespace-nowrap text-center">Requester</th>
                                        <th class="whitespace-nowrap text-center">Date</th>
                                        <th class="whitespace-nowrap text-center">Scheduled Time</th>
                                        <th class="whitespace-nowrap text-center">Language</th>
                                        <th class="whitespace-nowrap text-center">Session Format</th>
                                        <th class="whitespace-nowrap text-center">Session Location</th>
                                        <th class="whitespace-nowrap text-center">Session Title</th>
                                        <th class="whitespace-nowrap text-center">Quote</th>
                                        <th class="whitespace-nowrap">C. Rate</th>
                                        <th class="whitespace-nowrap">C. Adjust</th>
                                        <th class="whitespace-nowrap">C. Fee</th>
                                        <th class="whitespace-nowrap">C. Adjust Note</th>
                                        <th class="whitespace-nowrap">C. Paid</th>
                                        <th class="whitespace-nowrap text-center">Interpreter</th>
                                        <th class="whitespace-nowrap text-center">Interpreter Message</th>
                                        <th class="whitespace-nowrap text-center">I.Rate</th>
                                        <th class="whitespace-nowrap text-center">I.Adjust ($)</th>
                                        <th class="whitespace-nowrap text-center">I. Fee</th>
                                        <th class="whitespace-nowrap text-center">I. Adjust Note</th>
                                        <th class="whitespace-nowrap text-center">I. Paid</th>
                                        <th class="whitespace-nowrap text-center">Created At</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($interpretations as $key => $interpretation)
                                        <tr>
                                            <td class="whitespace-nowrap">
                                                <div class="flex gap-1">
                                                    <a href="{{ route('admin-view-interpretation-details', $interpretation->id) }}"
                                                        class="btn bg-yellow-500"><svg class="w-5 h-5 text-white mx-auto"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                                        </svg></a>
                                                    <a href="{{ route('admin.interpretation.edit', $interpretation->id) }}"
                                                        class="btn btn-warning"><svg class="w-5 h-5 text-white mx-auto"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg></a>

                                                    <div class="text-center">
                                                        <a href="{{ route('admin-copy-interpretation-details', $interpretation->id) }}"
                                                            class="btn btn-pending"><svg
                                                                class="w-4 h-4 text-white dark:text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 16 20">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" stroke-width="2"
                                                                    d="M2 5a1 1 0 0 0-1 1v12a.969.969 0 0 0 .933 1h8.1a1 1 0 0 0 1-1.033M10 1v4a1 1 0 0 1-1 1H5m10-4v12a.97.97 0 0 1-.933 1H5.933A.97.97 0 0 1 5 14V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 9.828 1h4.239A.97.97 0 0 1 15 2Z" />
                                                            </svg></a>
                                                    </div>
                                                    <div class="text-center"> <a href="javascript:;"
                                                            data-tw-toggle="modal"
                                                            data-tw-target="#track-modal-preview{{ $interpretation->id }}"
                                                            class="btn btn-success">
                                                            <svg class="w-5 h-5 text-white mx-auto"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    @if ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 && $interpretation->paymentStatus == 0)
                                                        <a href="{{ route('admin.showSubmitQuote', $interpretation->id) }}"
                                                            class="btn btn-warning mr-1">Send
                                                            Invoice</a>
                                                    @elseif (
                                                        $interpretation->wantQuote == 0 &&
                                                            $interpretation->invoiceSent == 1 &&
                                                            $interpretation->paymentStatus == 1 &&
                                                            $interpretation->interpreter_id === null &&
                                                            $interpretation->interpreter_completed == 0)
                                                        <a href="{{ route('view-assign-interpreter', $interpretation->id) }}"
                                                            class="btn bg-green-700 mr-1" title="Assign">
                                                            <svg class="w-5 h-5 text-white mx-auto"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                                            </svg>

                                                        </a>
                                                    @elseif (
                                                        $interpretation->wantQuote == 0 &&
                                                            $interpretation->invoiceSent == 1 &&
                                                            $interpretation->paymentStatus == 1 &&
                                                            $interpretation->interpreter_id !== null &&
                                                            $interpretation->interpreter_completed == 0)
                                                        <a href="{{ route('view-assign-interpreter', $interpretation->id) }}"
                                                            class="btn bg-green-700 mr-1" title="Assign">
                                                            <svg class="w-5 h-5 text-white mx-auto"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                                            </svg>
                                                        </a>
                                                    @elseif (
                                                        $interpretation->wantQuote == 0 &&
                                                            $interpretation->invoiceSent == 1 &&
                                                            $interpretation->paymentStatus == 1 &&
                                                            $interpretation->interpreter_id !== null &&
                                                            $interpretation->interpreter_completed == 1 &&
                                                            1 == 2)
                                                        <button class="btn btn-warning mr-1  ">View Feedback</button>
                                                    @elseif ($interpretation->wantQuote == 1)
                                                        <a href="{{ route('admin.showSubmitQuote', $interpretation->id) }}"
                                                            class="btn btn-warning mr-1  ">
                                                            Quote</a>
                                                        {{-- @elseif ($interpretation->wantQuote == 2)
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
                                            </button> --}}
                                                    @elseif (
                                                        $interpretation->wantQuote == 3 &&
                                                            $interpretation->paymentStatus == 1 &&
                                                            $interpretation->interpreter_id === null &&
                                                            $interpretation->interpreter_completed == 0)
                                                        <a href="{{ route('view-assign-interpreter', $interpretation->id) }}"
                                                            class="btn bg-green-700 mr-1" title="Assign">
                                                            <svg class="w-5 h-5 text-white mx-auto"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                                            </svg>
                                                        </a>
                                                    @elseif (
                                                        $interpretation->wantQuote == 3 &&
                                                            $interpretation->paymentStatus == 1 &&
                                                            $interpretation->interpreter_id !== null &&
                                                            $interpretation->interpreter_completed == 0)
                                                        <a href="{{ route('view-re-assign-interpreter', $interpretation->id) }}"
                                                            class="btn btn-warning mr-1  ">Re-Assign
                                                        </a>
                                                    @elseif (
                                                        $interpretation->wantQuote == 3 &&
                                                            $interpretation->paymentStatus == 1 &&
                                                            $interpretation->interpreter_id !== null &&
                                                            $interpretation->interpreter_completed == 1 &&
                                                            1 == 2)
                                                        <button class="btn btn-warning mr-1  ">View Feedback</button>
                                                    @endif
                                                    <div class="text-center"> <a href="javascript:;"
                                                            data-tw-toggle="modal"
                                                            data-tw-target="#delete-modal-preview{{ $interpretation->id }}"
                                                            class="btn btn-danger">
                                                            <svg class="w-5 h-5 text-white mx-auto"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <div id="delete-modal-preview{{ $interpretation->id }}"
                                                        class="modal" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-0">
                                                                    <div class="p-5 text-center"> <i
                                                                            data-lucide="x-circle"
                                                                            class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                                        <div class="text-3xl mt-5">Are you sure?</div>
                                                                        <div class="text-slate-500 mt-2">Do you really want
                                                                            to delete
                                                                            this
                                                                            order? <br>This process cannot
                                                                            be undone.</div>
                                                                    </div>
                                                                    <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                        style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                        <button type=" button" data-tw-dismiss="modal"
                                                                            class="btn btn-outline-secondary w-24 mr-1 self-center">
                                                                            Cancel</button>
                                                                        <form
                                                                            action="{{ route('admin.interpretation.delete', $interpretation->id) }}"
                                                                            method="POST">
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
                                                    {{-- <button type="submit" class="btn btn-danger bg-red-600 text-black">
                                                        <div>
                                                            <form
                                                                action="{{ route('admin.interpretation.delete', $interpretation->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <svg class="w-5 h-5 text-white mx-auto"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                </svg>

                                                            </form>
                                                        </div>
                                                    </button> --}}
                                                    @if ($interpretation->interpreter_id == null)
                                                        <div class="text-center">
                                                            <form action="{{ route('admin-cancelInterpretation') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="interpretation_id"
                                                                    value="{{ $interpretation->id }}">
                                                                <button type="submit" class="btn bg-red-500 btn-danger">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="2.5"
                                                                        stroke="currentColor" class="w-5 h-5">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap w-40">
                                                @include('utils.interpretation-status-column', [
                                                    'interpretation' => $interpretation,
                                                ])
                                            </td>
                                            {{-- @dd($interpretation->user->institute) --}}
                                            <td class="whitespace-nowrap" style="display: none">
                                                {{ $interpretation->interpreter_completed }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->worknumber }}</td>
                                            @if ($interpretation->added_by_institute_user)
                                                <td class="whitespace-nowrap">
                                                    @foreach ($interpretation->user->institute as $institute)
                                                        {{ $institute->name }}
                                                    @endforeach
                                                </td>
                                            @else
                                                <td>

                                                </td>
                                            @endif
                                            <td class="whitespace-nowrap">{{ $interpretation->user->name }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->interpretationDate }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ \App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->start_time) }}
                                                -
                                                {{ \App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->end_time) }}
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->language }}</td>

                                            <td class="whitespace-nowrap">{{ $interpretation->session_format }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->location }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->session_topics ?? '-' }}
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
                                                                <div class="text-3xl mt-5 mb-2">Interpretation Quote
                                                                </div>
                                                                <div class="w-full text-center">
                                                                    @if ($interpretation->quote_description)
                                                                        <label for="order-form-21" class="form-label">
                                                                            Message:</label>
                                                                        <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $interpretation->quote_description }}</textarea>
                                                                    @endif
                                                                    @if ($interpretation->quote_filename != null)
                                                                        <div class="w-full mx-auto">
                                                                            <div class="col-12">
                                                                                <a href="{{ route('downloadInterpretationQuote', $interpretation->id) }}"
                                                                                    title="Download Final Document"
                                                                                    class="btn btn-success mr-1 mt-2">

                                                                                    Download Quote File
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            {{-- C Fields Start --}}
                                            <td class="whitespace-nowrap">${{ $interpretation->c_rate }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->c_adjust }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->c_fee }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->c_adjust_note }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ $interpretation->c_paid == 1 ? 'Yes' : 'No' }}</td>
                                            {{-- C Fields End --}}
                                            <td class="whitespace-nowrap">
                                                {{ $interpretation->contractorInterpretation->contractor->name ?? '-' }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#message2-modal-preview{{ $interpretation->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>
                                            <!-- BEGIN: Modal Content -->
                                            <div id="message2-modal-preview{{ $interpretation->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">Interpretation Message
                                                                </div>
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
                                                @if ($interpretation->contractorInterpretation == null)
                                                    N/A
                                                @else
                                                    ${{ $interpretation->contractorInterpretation->contractor->interpretation_rate }}
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($interpretation->interpreter_id === null || $interpretation->contractorInterpretation->estimated_payment == null)
                                                    N/A
                                                @else
                                                    ${{ $interpretation->contractorInterpretation->estimated_payment }}
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($interpretation->interpreter_id === null || $interpretation->contractorInterpretation->per_hour_rate == null)
                                                    N/A
                                                @else
                                                    ${{ $interpretation->contractorInterpretation->per_hour_rate }}
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#i-adjust-note-modal-preview{{ $interpretation->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>
                                            <!-- BEGIN: Modal Content -->
                                            <div id="i-adjust-note-modal-preview{{ $interpretation->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">Interpretation Adjust Note
                                                                </div>
                                                                <div class="w-full text-left">
                                                                    <label for="order-form-21" class="form-label">
                                                                        Message:</label>
                                                                    <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $interpretation->interpreter_adjust_note }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            <td class="whitespace-nowrap">
                                                {{ $interpretation->interpreter_paid == 1 ? 'Yes' : 'No' }}</td>

                                            <td class="whitespace-nowrap">
                                                {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($interpretation->created_at, request()->ip()) }}
                                            </td>
                                        </tr>
                                        <div id="track-modal-preview{{ $interpretation->id }}" class="modal w-full"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body p-0">
                                                        <div class="p-5 text-center"> <i data-lucide="target"
                                                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                                                            <div class="text-3xl mt-5">Track Order</div>
                                                        </div>
                                                        <div class="intro-y box py-10 mt-5">
                                                            <div class="loader text-center" role="status"
                                                                id="loader-{{ $interpretation->id }}"
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
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="container m-2 flex justify-end">
                            {{ $interpretations->appends(['limit' => session('limit'), 'page' => session('page')])->links() }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Data List -->
    <!-- END: Pagination -->
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
    {{-- <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}

    <script>
        // $(document).ready(function() {
        var table = $('#myinterpretationsTable').DataTable({
            dom: 'Bfrtip',
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
            ordering: true,
            info: false,
            paging: false,
        });
        console.log("table", table);
        $(document).ready(function() {

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var isPendingChecked = $('#checkbox-status-pending').is(':checked');
                    var isCompletedChecked = $('#checkbox-status-completed').is(':checked');

                    if (isPendingChecked && data[2] == 0) {
                        return true;
                    } else if (isCompletedChecked && data[2] == 1) {
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


            // sticky
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
                'User Info': [4, 5],
                'C. Info': [13, 14, 15, 16, 17],
                'Interpretation Info': [7, 8, 9, 10, 11, 12,
                    18, 19, 20, 21, 22, 23
                ],
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
        $(document).on('click', '.btn.btn-success', function() {
            var interpretationId = $(this).data('tw-target').replace('#track-modal-preview', '');
            console.log("Clicked Track", interpretationId);
            $('#loader-' + interpretationId).show();
            $.get('/interpretation/' + interpretationId + '/track', function(data) {
                $('#loader-' + interpretationId).hide();
                $('.intro-y.box.py-10.mt-5').html(data);
            });
        });
    </script>
    <script src="{{ asset('src/pagination-script.js') }}"></script>
@endsection
