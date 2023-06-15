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
<link rel="stylesheet" type="text/css" {{--
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" /> --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
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
                    <div class="overflow-x-auto">
                        <table id="myinterpretationsTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">Possible Action</th>
                                    <th style="width: 41.0469px;padding-left: 40px;padding-right: 40px;"
                                        class="whitespace-nowrap w-40 px-12">Status</th>
                                    <th class="whitespace-nowrap text-center" style="display: none">Interpretation
                                        Status</th>
                                    <th class="whitespace-nowrap text-center">Work Number</th>
                                    <th class="whitespace-nowrap text-center">Institute</th>
                                    <th class="whitespace-nowrap text-center">Name</th>
                                    <th class="whitespace-nowrap text-center">Email</th>
                                    <th class="whitespace-nowrap text-center">Language</th>
                                    <th class="whitespace-nowrap text-center">Interpretation Date</th>
                                    <th class="whitespace-nowrap text-center">Start Time</th>
                                    <th class="whitespace-nowrap text-center">End Time</th>
                                    <th class="whitespace-nowrap text-center">Session Format</th>
                                    <th class="whitespace-nowrap text-center">Interpreter Assigned</th>
                                    <th class="whitespace-nowrap text-center">I.Rate</th>
                                    <th class="whitespace-nowrap text-center">E.Payment</th>
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
                                            <button type="submit" class="btn btn-danger bg-red-600 text-black">
                                                <div>
                                                    <form
                                                        action="{{ route('admin.interpretation.delete', $interpretation->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <i data-lucide="trash-2" class="w-5 h-5 text-white mx-auto"></i>

                                                    </form>
                                                </div>
                                            </button>
                                            @if ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 &&
                                            $interpretation->paymentStatus == 0)
                                            <a href="{{ route('admin.showSubmitQuote', $interpretation->id) }}"
                                                class="btn btn-warning mr-1">Send
                                                Invoice</a>
                                            @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent ==
                                            1 && $interpretation->paymentStatus == 0)
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
                                                class="btn btn-pending mr-1">
                                                <i data-lucide="mail" class="w-4 h-4 mr-2"></i>Assign To
                                                Interpreter
                                            </a>
                                            @elseif (
                                            $interpretation->wantQuote == 0 &&
                                            $interpretation->invoiceSent == 1 &&
                                            $interpretation->paymentStatus == 1 &&
                                            $interpretation->interpreter_id !== null &&
                                            $interpretation->interpreter_completed == 0)
                                            <a href="{{ route('view-assign-interpreter', $interpretation->id) }}"
                                                class="btn btn-pending mr-1">
                                                <i data-lucide="mail" class="w-4 h-4 mr-2"></i>Assign To
                                                Interpreter
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
                                                class="btn btn-pending mr-1">
                                                <i data-lucide="mail" class="w-4 h-4 mr-2"></i>Assign To
                                                Interpreter
                                            </a>
                                            @elseif (
                                            $interpretation->wantQuote == 3 &&
                                            $interpretation->paymentStatus == 1 &&
                                            $interpretation->interpreter_id !== null &&
                                            $interpretation->interpreter_completed == 0)
                                            <a href="{{ route('view-re-assign-interpreter', $interpretation->id) }}"
                                                class="btn btn-warning mr-1  ">Re-Assign
                                                Interpreter</a>
                                            @elseif (
                                            $interpretation->wantQuote == 3 &&
                                            $interpretation->paymentStatus == 1 &&
                                            $interpretation->interpreter_id !== null &&
                                            $interpretation->interpreter_completed == 1)
                                            <button class="btn btn-warning mr-1  ">View Feedback</button>
                                            @endif


                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap w-40">
                                        @if ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 0 &&
                                        $interpretation->paymentStatus == 0)
                                        <div class="progress h-4">
                                            <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100">0%
                                            </div>
                                        </div>
                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 &&
                                        $interpretation->paymentStatus == 0)
                                        <div class="progress h-4">
                                            <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="25"
                                                aria-valuemin="0" aria-valuemax="100">25%
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
                                            <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100">0%
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
                                    <td class="whitespace-nowrap" style="display: none">{{
                                        $interpretation->interpreter_completed }}</td>
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
                                    <td class="whitespace-nowrap">{{ $interpretation->user->email }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->language }}</td>
                                    <td class="whitespace-nowrap">{{ $interpretation->interpretationDate }}</td>
                                    <td class="whitespace-nowrap">
                                        {{
                                        App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->start_time,
                                        request()->ip()) }}
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{
                                        App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->end_time,
                                        request()->ip()) }}
                                    </td>

                                    <td class="whitespace-nowrap">{{ $interpretation->session_format }}</td>
                                    <td class="whitespace-nowrap">
                                        @if ($interpretation->interpreter_id === null)
                                        N/A
                                        @else
                                        {{ $interpretation->interpreter->name }}
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @if ($interpretation->interpreter_id === null ||
                                        $interpretation->contractorInterpretation->per_hour_rate == null)
                                        N/A
                                        @else
                                        ${{ $interpretation->contractorInterpretation->per_hour_rate }}
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @if ($interpretation->interpreter_id === null ||
                                        $interpretation->contractorInterpretation->estimated_payment == null)
                                        N/A
                                        @else
                                        ${{ $interpretation->contractorInterpretation->estimated_payment }}
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap">
                                        {{
                                        App\Helpers\HelperClass::convertDateToCurrentTimeZone($interpretation->created_at,
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
</div>
<!-- END: Data List -->
<!-- END: Pagination -->
{{-- </div> --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
            var table = $('#myinterpretationsTable').DataTable({
                ordering: true,
                info: true,
                paging: true
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
                'Interpretation Info': [7,8,9,10,11,12,13,14],
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
@endsection