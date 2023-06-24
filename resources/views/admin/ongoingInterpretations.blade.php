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

    {{-- <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-html5-2.3.6/datatables.min.css" rel="stylesheet"/> --}}
    {{-- <link   href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css"/> --}}
    <!-- Buttons CSS -->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" /> --}}
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
                                        <th style="display:none" class="whitespace-nowrap w-40 px-12 sticky-column-1">Status
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
                                        {{-- <th class="whitespace-nowrap">C. Rate</th>
                                        <th class="whitespace-nowrap">C. Adjust</th>
                                        <th class="whitespace-nowrap">C. Fee</th>
                                        <th class="whitespace-nowrap">C. Adjust Note</th>
                                        <th class="whitespace-nowrap">C. Paid</th> --}}
                                        <th class="whitespace-nowrap text-center">Interpreter</th>
                                        <th class="whitespace-nowrap text-center">Interpreter Message</th>
                                        <th class="whitespace-nowrap text-center">I.Rate</th>
                                        <th class="whitespace-nowrap text-center">I.Adjust ($)</th>
                                        {{-- <th class="whitespace-nowrap text-center">I. Fee</th> --}}
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
                                                    <a href="{{ route('admin.interpretation.edit', $interpretation->id) }}"
                                                        class="btn btn-warning"><i data-lucide="edit"
                                                            class="w-5 h-5 text-white mx-auto"></i></a>
                                                    <a href="{{ route('view-interpretation-details', $interpretation->id) }}"
                                                        class="btn btn-secondary"><i data-lucide="view"
                                                            class="w-5 h-5 text-white mx-auto"></i></a>
                                                    <button type="submit" class="btn btn-danger bg-red-600 text-black">
                                                        <div>
                                                            <form
                                                                action="{{ route('admin.interpretation.delete', $interpretation->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <i data-lucide="trash-2"
                                                                    class="w-5 h-5 text-white mx-auto"></i>

                                                            </form>
                                                        </div>
                                                    </button>
                                                    <div class="text-center"> <a href="javascript:;"
                                                            data-tw-toggle="modal"
                                                            data-tw-target="#track-modal-preview{{ $interpretation->id }}"
                                                            class="btn btn-success"><i data-lucide="target"
                                                                class="w-5 h-5 text-white mx-auto"></i></a>
                                                    </div>
                                                    @if ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 && $interpretation->paymentStatus == 0)
                                                        <a href="{{ route('admin.showSubmitQuote', $interpretation->id) }}"
                                                            class="btn btn-warning mr-1">Send
                                                            Invoice</a>
                                                    @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 && $interpretation->paymentStatus == 0)
                                                        <button class="btn btn-warning mr-1">Waiting for Payment <i
                                                                data-loading-icon="three-dots" data-color="1a202c"
                                                                class="w-4 h-4 ml-2"></i></button>
                                                    @elseif (
                                                        $interpretation->wantQuote == 0 &&
                                                            $interpretation->invoiceSent == 1 &&
                                                            $interpretation->paymentStatus == 1 &&
                                                            $interpretation->interpreter_id === null &&
                                                            $interpretation->interpreter_completed == 0)
                                                        <a href="{{ route('view-assign-interpreter', $interpretation->id) }}"
                                                            class="btn btn-pending mr-1" title="Assign">
                                                            <i data-lucide="user-plus"
                                                                class="w-5 h-5 text-white mx-auto"></i>
                                                        </a>
                                                    @elseif (
                                                        $interpretation->wantQuote == 0 &&
                                                            $interpretation->invoiceSent == 1 &&
                                                            $interpretation->paymentStatus == 1 &&
                                                            $interpretation->interpreter_id !== null &&
                                                            $interpretation->interpreter_completed == 0)
                                                        <a href="{{ route('view-assign-interpreter', $interpretation->id) }}"
                                                            class="btn btn-pending mr-1" title="Assign">
                                                            <i data-lucide="user-plus"
                                                                class="w-5 h-5 text-white mx-auto"></i>
                                                        </a>
                                                    @elseif (
                                                        $interpretation->wantQuote == 0 &&
                                                            $interpretation->invoiceSent == 1 &&
                                                            $interpretation->paymentStatus == 1 &&
                                                            $interpretation->interpreter_id !== null &&
                                                            $interpretation->interpreter_completed == 1)
                                                        <button class="btn btn-warning mr-1  ">View Feedback</button>
                                                    @elseif ($interpretation->wantQuote == 1)
                                                        <a href="{{ route('admin.showSubmitQuote', $interpretation->id) }}"
                                                            class="btn btn-warning mr-1  ">Submit
                                                            Quote</a>
                                                    @elseif ($interpretation->wantQuote == 2)
                                                        <button class="btn btn-warning mr-1  ">Waiting for Payment <i
                                                                data-loading-icon="three-dots" data-color="1a202c"
                                                                class="w-4 h-4 ml-2"></i></button>
                                                    @elseif (
                                                        $interpretation->wantQuote == 3 &&
                                                            $interpretation->paymentStatus == 1 &&
                                                            $interpretation->interpreter_id === null &&
                                                            $interpretation->interpreter_completed == 0)
                                                        <a href="{{ route('view-assign-interpreter', $interpretation->id) }}"
                                                            class="btn btn-pending mr-1" title="Assign">
                                                            <i data-lucide="user-plus"
                                                                class="w-5 h-5 text-white mx-auto"></i>
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
                                                            $interpretation->interpreter_completed == 1)
                                                        <button class="btn btn-warning mr-1  ">View Feedback</button>
                                                    @endif


                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap w-40" style="display: none">
                                                @if ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 && $interpretation->paymentStatus == 0)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-1/4" role="progressbar"
                                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                                                        </div>
                                                    </div>
                                                @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 && $interpretation->paymentStatus == 0)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-1/4" role="progressbar"
                                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%
                                                        </div>
                                                    </div>
                                                @elseif (
                                                    $interpretation->wantQuote == 0 &&
                                                        $interpretation->invoiceSent == 1 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id === null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-2/4 bg-primary" role="progressbar"
                                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%
                                                        </div>
                                                    </div>
                                                @elseif (
                                                    $interpretation->wantQuote == 0 &&
                                                        $interpretation->invoiceSent == 1 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-3/4 bg-pending" role="progressbar"
                                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%
                                                        </div>
                                                    </div>
                                                @elseif (
                                                    $interpretation->wantQuote == 0 &&
                                                        $interpretation->invoiceSent == 1 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 1)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-full bg-success" role="progressbar"
                                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            100%
                                                        </div>
                                                    </div>
                                                @elseif ($interpretation->wantQuote == 1)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-1/4" role="progressbar"
                                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                                                        </div>
                                                    </div>
                                                @elseif ($interpretation->wantQuote == 2 && $interpretation->paymentStatus == 0)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-1/2 bg-warning" role="progressbar"
                                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%
                                                        </div>
                                                    </div>
                                                @elseif ($interpretation->wantQuote == 2 && $interpretation->paymentStatus == 1)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-3/4 bg-primary" role="progressbar"
                                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%
                                                        </div>
                                                    </div>
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id === null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-3/4 bg-primary" role="progressbar"
                                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%
                                                        </div>
                                                    </div>
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 0)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-3/4 bg-pending" role="progressbar"
                                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%
                                                        </div>
                                                    </div>
                                                @elseif (
                                                    $interpretation->wantQuote == 3 &&
                                                        $interpretation->paymentStatus == 1 &&
                                                        $interpretation->interpreter_id !== null &&
                                                        $interpretation->interpreter_completed == 1)
                                                    <div class="progress h-4">
                                                        <div class="progress-bar w-full bg-success" role="progressbar"
                                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            100%
                                                        </div>
                                                    </div>
                                                @endif
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
                                                {{ App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->start_time, request()->ip()) }}
                                                -
                                                {{ App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->end_time, request()->ip()) }}
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->language }}</td>

                                            <td class="whitespace-nowrap">{{ $interpretation->session_format }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->location }}</td>
                                            <td class="whitespace-nowrap">{{ $interpretation->session_topics ?? '-' }}
                                            </td>
                                            <td title="{{ $interpretation->quote_description }}"><i
                                                    data-lucide="message-square" class="w-100 h-5"> </i>
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->interpreter->name ?? '-' }}
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->message }}</td>


                                            <td class="whitespace-nowrap">
                                                @if ($interpretation->interpreter_id === null || $interpretation->contractorInterpretation->per_hour_rate == null)
                                                    N/A
                                                @else
                                                    ${{ $interpretation->contractorInterpretation->per_hour_rate }}
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($interpretation->interpreter_id === null || $interpretation->contractorInterpretation->estimated_payment == null)
                                                    N/A
                                                @else
                                                    ${{ $interpretation->contractorInterpretation->estimated_payment }}
                                                @endif
                                            </td>
                                            <td title="{{ $interpretation->interpreter_adjust_note ?? '' }}"><i
                                                    data-lucide="message-square" class="w-100 h-5"> </i>
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->interpreter_paid }}</td>

                                            <td class="whitespace-nowrap">
                                                {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($interpretation->created_at, request()->ip()) }}
                                            </td>
                                        </tr>
                                        <div id="track-modal-preview{{ $interpretation->id }}" class="modal"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body p-0">
                                                        <div class="p-5 text-center"> <i data-lucide="target"
                                                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                                                            <div class="text-3xl mt-5">Track Order</div>
                                                        </div>
                                                        <div class="intro-y box py-10 mt-5">
                                                            {{-- @include('utils.track-interpretation', [
                                                                'order' => $interpretation,
                                                            ]) --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
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
        $(document).ready(function() {
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
                info: true,
                paging: true,
                pageLength: 4,
            });
            console.log("table", table);

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
                'User Info': [3, 5, 6],
                'Interpretation Info': [7, 8, 9, 10, 11, 12, 13, 14],
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
        $('.btn.btn-success').on('click', function() {
            var interpretationId = $(this).data('tw-target').replace('#track-modal-preview', '');
            console.log("Clicked Track", interpretationId);
            $.get('/interpretation/' + interpretationId + '/track', function(data) {
                $('.intro-y.box.py-10.mt-5').html(data);
            });
        });
    </script>
@endsection
