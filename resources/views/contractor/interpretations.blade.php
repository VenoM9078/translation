@extends('contractor.layout')

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
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                On-Going Interpretations
            </h2>
        </div>

        @if ($message = Session::get('message'))
            <div class="alert alert-success mt-3">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="flex justify-end gap-4">
            <div class="flex justify-end gap-4">
                <div class="dropdown-container  relative inline-block my-2">
                    @include('utils.limit-data-dropdown', ['route' => 'contractor.interpretations'])
                </div>
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
        <div class="intro-y box">
            <div id="vertical-form" class="p-5">
                <div class="preview">
                    <div>
                        <div class="overflow-x-auto">


                            <table id="interpretationsTable" class="table table-striped hover" style="width:100%">


                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">Worknumber</th>
                                        <th class="whitespace-nowrap">Topic</th>
                                        <th class="whitespace-nowrap">Language</th>
                                        <th class="whitespace-nowrap">Interpretation Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th class="whitespace-nowrap">Session Format</th>
                                        <th class="whitespace-nowrap">Address/Link</th>
                                        <th class="whitespace-nowrap">Per Hour Rate</th>
                                        <th class="whitespace-nowrap">Estimated Payment</th>
                                        <th>Status</th>
                                        <th class="whitespace-nowrap">Possible Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($interpretations as $key => $interpretation)
                                        <tr
                                            data-status="{{ $interpretation->interpretation->interpreter_completed == 1 ? 'completed' : 'pending' }}">
                                            <td class="whitespace-nowrap">{{ $interpretation->interpretation->worknumber }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                {{ $interpretation->interpretation->session_topics }}
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->interpretation->language }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                {{ $interpretation->interpretation->interpretationDate }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ \App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->start_time) }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                {{ \App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->end_time) }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                {{ $interpretation->interpretation->session_format }}
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->interpretation->location }}
                                            </td>
                                            <td class="whitespace-nowrap">${{ $interpretation->per_hour_rate }}</td>
                                            <td class="whitespace-nowrap">${{ $interpretation->estimated_payment }}</td>
                                            <td>{{ $interpretation->interpretation->interpreter_completed == 1 ? 'Completed' : 'Pending' }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                <div class="flex">
                                                    @if (!$interpretation->is_accepted)
                                                        <div>
                                                            <div class="text-center"> <a href="javascript:;"
                                                                    data-tw-toggle="modal"
                                                                    data-tw-target="#offer-modal-accept-{{ $key }}"
                                                                    class="btn btn-success">Accept</a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="text-center"> <a href="javascript:;"
                                                                    data-tw-toggle="modal"
                                                                    data-tw-target="#offer-modal-reject-{{ $key }}"
                                                                    class="btn btn-danger ml-1">Reject</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <a href="{{ route('contractor.viewReport', $interpretation->id) }}"
                                                            class="btn btn-warning mr-1 mb-2"><i data-lucide="thumbs-up"
                                                                class="w-4 h-4 mr-2"></i>Report</a>

                                                        @if ($interpretation->interpretation->interpreter_completed == 1)
                                                            <form
                                                                action="{{ route('interpretation.delete', $interpretation->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn bg-red-500 btn-danger mr-2 mb-2">
                                                                    <i data-lucide="trash" class="w-4 h-4 mr-2"></i>
                                                                    Cancel
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- BEGIN: Modal Content -->
                                            <div id="offer-modal-accept-{{ $key }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
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
                                                                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                                </svg>
                                                                <div class="text-3xl mt-5">Are you sure?</div>
                                                                <div class="text-slate-500 mt-2">Your action will advance
                                                                    this
                                                                    request and notify the Admin of your agreement!</div>
                                                            </div>
                                                            <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                <a href="{{ route('accept.request', $interpretation->id) }}"
                                                                    class="btn btn-success text-white w-24 mr-1 self-center">
                                                                    I'm Sure</a>
                                                                <button type="button" data-tw-dismiss="modal"
                                                                    class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->

                                            <!-- BEGIN: Modal Content -->
                                            <div id="offer-modal-reject-{{ $key }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="x-circle"
                                                                    class="w-16 h-16 text-danger mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5">Are you sure?</div>
                                                                <div class="text-slate-500 mt-2">Rejecting will delete this
                                                                    request from your Dashboard and notify the Admin of your
                                                                    actions.</div>
                                                            </div>
                                                            <div class="px-5 pb-8 text-center inline-flex items-stretch"
                                                                style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                <a href="{{ route('deny.request', $interpretation->id) }}"
                                                                    class="btn btn-danger w-24 mr-1 self-center">
                                                                    I'm Sure</a>
                                                                <button type="button" data-tw-dismiss="modal"
                                                                    class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        interpretations
                        <div class="container m-2 flex justify-end">
                            {{ $interpretations->appends(['limit' => session('limit'), 'page' => session('page')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

        <script>
            let button = document.querySelector('#uniqueModal');

            button.addEventListener('click', function() {
                let value = button.value;

                console.log(value);
            })
        </script>


        <script>
            $(document).ready(function() {
                var table = $('#interpretationsTable').DataTable({
                    dom: 'Brtip',
                    ordering: true,
                    info: true,
                    paging: false
                });

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var isPendingChecked = $('#checkbox-status-pending').is(':checked');
                        var isCompletedChecked = $('#checkbox-status-completed').is(':checked');

                        if (isPendingChecked && data[10] == 'Pending') {
                            return true;
                        } else if (isCompletedChecked && data[10] == 'Completed') {
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
                    'Date/Time Information': [3, 4, 5],
                    'Payment Information': [8, 9]
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
        $(document).ready(function() {
                var table = $('#interpretationsTable').DataTable({
                    ordering: true,
                    info: true,
                    paging: true
                });

                $('button.toggle-vis').on('click', function (e) {
                e.preventDefault();
                
                // Get the column API object
                var column = table.column($(this).attr('data-column'));
                
                // Toggle the visibility
                column.visible(!column.visible());
                });
            });
    </script> --}}
        <script src="{{ asset('src/pagination-script.js') }}"></script>
    @endsection
