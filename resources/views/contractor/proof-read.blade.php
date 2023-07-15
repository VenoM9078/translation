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

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                All On-Going Proofreads
            </h2>
        </div>

        @if ($message = Session::get('message'))
            <div class="alert alert-success mt-3">
                <p>{{ $message }}</p>
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
                <div hidden id="dropdownListStatus" class="z-10 hidden bg-white rounded-lg shadow dark:bg-gray-700">
                    <ul class=" space-y-1 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownBgHoverButtonStatus">
                        @foreach (\App\Enums\OrderStatusEnum::OrderStatuses as $key => $status)
                            <li>
                                <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input checked
                                        id="checkbox-status-{{ strtolower(str_replace(' ', '-', $status)) }}-{{ $key }}"
                                        type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 status-filter"
                                        data-status="{{ strtolower($status) }}">
                                    <label
                                        for="checkbox-status-{{ strtolower(str_replace(' ', '-', $status)) }}-{{ $key }}"
                                        class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{ $status }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="intro-y box">
            <div id="vertical-form" class="p-5">
                <div class="preview">
                    <div>
                        <div class="overflow-x-auto">
                            <table id="proofReadTable" class="table table-striped hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">WO#</th>
                                        <th class="whitespace-nowrap">ProofRead Due Date</th>
                                        <th class="whitespace-nowrap">Source Language</th>
                                        <th class="whitespace-nowrap">Target Language</th>
                                        <th class="whitespace-nowrap">Original Doc</th>
                                        <th class="whitespace-nowrap">Translated Doc</th>
                                        <th class="whitespace-nowrap">ProofRead Doc</th>
                                        <th class="whitespace-nowrap">Message</th>
                                        <th class="whitespace-nowrap">Proof Read Status</th>
                                        <th class="whitespace-nowrap">ProofRead Type</th>
                                        <th class="whitespace-nowrap">P. Rate($/Wd or $/Pg)</th>
                                        <th class="whitespace-nowrap">P. Adjust($)</th>
                                        <th class="whitespace-nowrap">P. Fee</th>
                                        <th class="whitespace-nowrap">P. Adjust Note</th>
                                        <th class="whitespace-nowrap">P. Paid</th>
                                        <th class="whitespace-nowrap">Order By</th>
                                        <th class="whitespace-nowrap">Order Status</th>
                                        <th class="whitespace-nowrap">User Email</th>
                                        <th class="whitespace-nowrap">Total Payment</th>
                                        <th class="whitespace-nowrap">Created At</th>
                                        <th class="whitespace-nowrap">Possible Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proofReadData as $key => $translation)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $translation->order->worknumber }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->proof_read_due_date }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->language1 }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->language2 }}</td>
                                            <td class="whitespace-nowrap"><a
                                                    href="{{ route('contractor.downloadFiles', $translation->order->id) }}"
                                                    class="btn btn-warning mr-1">
                                                    <i data-lucide="download" class="w-5 h-5"></i> </a></td>
                                            <td class="whitespace-nowrap">
                                                @if (isset($translation->contractor->contractorOrders) && count($translation->contractor->contractorOrders) > 0)
                                                    <a href="{{ route('contractor.download-translation-file', $translation->contractor->contractorOrders[0]->id) }}"
                                                        class="btn btn-success">
                                                        <i data-lucide="download" class="w-5 h-5"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('contractor.download-translated-file-by-admin', $translation->id) }}"
                                                        class="btn btn-success"> <i data-lucide="download"
                                                            class="w-5 h-5"></i>
                                                    </a>
                                                @endif
                                                {{-- </div> --}}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                {{-- @if ($translation->file_name != null) --}}
                                                <a class="btn btn-primary" title="Download ProofRead File"
                                                    href="{{ route('contractor.download-proof-read-file', $translation->order->id) }}">
                                                    <i data-lucide="download" class="w-5 h-5"></i>
                                                </a>

                                            </td>

                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#proofread-note-modal-preview{{ $translation->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($translation->is_accepted == 1)
                                                    @if ($translation->file_name != null)
                                                        Completed
                                                    @else
                                                        On-Going
                                                    @endif
                                                @else
                                                    ProofRead Order Not Accepted Yet
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap">{{ $translation->proofread_type }}</td>
                                            <td class="whitespace-nowrap">
                                                ${{ $translation->contractor->proofreader_rate }}
                                            </td>
                                            <td class="whitespace-nowrap">${{ $translation->total_payment }}</td>
                                            <td class="whitespace-nowrap">${{ $translation->rate }}</td>
                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#proofread-adj-note-modal-preview{{ $translation->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>

                                            <td class="whitespace-nowrap">
                                                {{ $translation->proof_read_paid == 1 ? 'Yes' : 'No' }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->user->name }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->orderStatus }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->user->email }}</td>
                                            <td class="whitespace-nowrap">${{ $translation->total_payment }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($translation->created_at, request()->ip()) }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @if ($translation->is_accepted == 0)
                                                    <div class="flex gap-2">
                                                        <div>
                                                            <div class="text-center"> <a href="javascript:;"
                                                                    data-tw-toggle="modal"
                                                                    data-tw-target="#proofread-modal-accept-{{ $key }}"
                                                                    class="btn btn-success">Accept</a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="text-center"> <a href="javascript:;"
                                                                    data-tw-toggle="modal"
                                                                    data-tw-target="#proofread-modal-reject-{{ $key }}"
                                                                    class="btn btn-danger">Reject</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="flex gap-2">
                                                        @if ($translation->order->proofread_status != 1)
                                                            <div>
                                                                <a href="{{ route('contractor.view-proof-read-submission', $translation->id) }}"
                                                                    class="btn btn-success">Submit File
                                                                </a>
                                                            </div>
                                                        @elseif($translation->order->proofread_status == 1)
                                                            <div>
                                                                <a href="{{ route('contractor.view-proof-read-submission', $translation->id) }}"
                                                                    class="btn btn-success">Re-Submit File
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            <div id="proofread-adj-note-modal-preview{{ $translation->id }}"
                                                class="modal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">ProofReader Adjust Note
                                                                </div>
                                                                <div class="w-full text-left">
                                                                    <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $translation->proof_read_adjust_note }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            <div id="proofread-note-modal-preview{{ $translation->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">ProofReader Message
                                                                </div>
                                                                <div class="w-full text-left">
                                                                    <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $translation->message ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            <!-- BEGIN: Modal Content -->
                                            <div id="proofread-modal-accept-{{ $key }}" class="modal"
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
                                                                <a href="{{ route('proof-read-accept.request', $translation->id) }}"
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
                                            <div id="proofread-modal-reject-{{ $key }}" class="modal"
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
                                                                <a href="{{ route('proof-read-deny.request', $translation->id) }}"
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
                        <div class="container m-2 flex justify-end">
                            {{ $proofReadData->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js">
    </script>
    <script>
        // let button = document.querySelector('#uniqueModal');

        // button.addEventListener('click', function() {
        //     let value = button.value;

        //     console.log(value);
        // })
        $(document).ready(function() {
            var OrderStatuses = @json(\App\Enums\OrderStatusEnum::OrderStatuses);
            var table = $('#proofReadTable').DataTable({
                scrollX: true,
                scrollCollapse: true,
                // ordering: true,
                info: true,
                // paging: true,
                fixedColumns: {
                    leftColumn: 1
                }
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var checkedStatuses = [];

                    for (var key in OrderStatuses) {
                        var status = OrderStatuses[key];
                        var id = 'checkbox-status-' + status.toLowerCase().split(' ').join('-') + '-' + key;
                        var isChecked = $('#' + id).is(':checked');

                        if (isChecked) {
                            checkedStatuses.push(status);
                        }
                    }

                    if (checkedStatuses.includes(data[16])) {
                        return true; // row should appear
                    } else {
                        return false; // row should not appear
                    }
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
                'Order Info': [0, 2, 3, 4],
                'Translator Info': [1, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
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
