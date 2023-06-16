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


    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js">
    </script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                On-Going Translations
            </h2>
        </div>

        @if ($message = Session::get('message'))
            <div class="alert alert-success mt-3">
                <p>{{ $message }}</p>
            </div>
        @endif
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
                                    class="w-full ml-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Invoice
                                    Pending</label>
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
                            <table id="ordersTable" class="table table-striped hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">Order WorkNumber</th>
                                        <th class="whitespace-nowrap">Amount</th>
                                        <th class="whitespace-nowrap">Order By</th>
                                        <th class="whitespace-nowrap">Language</th>
                                        <th class="whitespace-nowrap">Rate Accepted</th>
                                        <th>Created At</th>
                                        <th class="whitespace-nowrap">Status</th>
                                        <th class="whitespace-nowrap">Possible Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($translations as $key => $translation)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $translation->order->worknumber }}</td>
                                            <td class="whitespace-nowrap">${{ $translation->total_payment }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->user->name }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->language1 }}</td>
                                            <td class="whitespace-nowrap">${{ $translation->order->contractorOrder->rate }}
                                            </td>

                                            <td class="whitespace-nowrap">
                                                {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($translation->created_at, request()->ip()) }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                {{ $translation->is_accepted == 1 ? 'Accepted' : 'Pending' }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                <div class="flex gap-2">
                                                    @if ($translation->is_accepted == 1)
                                                        <a href="{{ route('contractor.downloadFiles', $translation->order_id) }}"
                                                            class="btn btn-warning mr-1 mb-2"> <i data-lucide="download"
                                                                class="w-5 h-5"></i> </a>
                                                        <!-- BEGIN: Modal Toggle -->
                                                        <div class="text-center">
                                                            <a href="{{ route('contractor.view-submit-translation', $translation->id) }}"
                                                                class="btn btn-primary">
                                                                <i data-lucide="upload" class="w-5 h-5"
                                                                    title="Upload for Submission"></i>
                                                            </a>
                                                        </div> <!-- END: Modal Toggle -->
                                                    @endif
                                                </div>
                                            </td>
                                            <!-- BEGIN: Modal Content -->
                                            {{-- <div id="upload-modal-preview-{{ $key }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="p-5 text-center"> <i data-lucide="info"
                                                                            class="w-16 h-8 text-danger mx-auto mt-3"></i>
                                                                        <div class="text-3xl mt-5">Upload Translation</div>
                                                                    </div>
                                                                    <div class=" text-center "
                                                                        style="text-align: center;margin: auto !important;width: 100%;position: relative;justify-content: center;">
                                                                        <form
                                                                            action="{{ route('contractor.upload-translation') }}"
                                                                            method="post" enctype="multipart/form-data"
                                                                            accept-charset="utf-8">
                                                                            @csrf
                                                                            @method('POST')
                                                                            <input type="hidden" name="contractor_order_id"
                                                                                value="{{ $translation->id }}">
                                                                            <div class="col-span-12 p-2 sm:col-span-12">
                                                                                <input type="file"
                                                                                    id="fp-translationFile-{{$key}}" class="filepond fp-translationFile"
                                                                                    name="translationFile[]" multiple data-max-files="1" 
                                                                                    data-max-file-size="10MB" />
                                                                                <button type="submit"
                                                                                    class="btn btn-success w-24">Submit</button>
                                                                            </div>
                                                                            <!-- END: Modal Toggle -->
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content --> --}}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js">
    </script>
    <script>
        $(document).ready(function() {
            FilePond.registerPlugin(

                // encodes the file as base64 data
                FilePondPluginFileEncode,

                // validates the size of the file
                FilePondPluginFileValidateSize,

                // corrects mobile image orientation
                FilePondPluginImageExifOrientation,

                // previews dropped images
                FilePondPluginImagePreview
            );

            // Select the file input and use create() to turn it into a pond
            FilePond.create(
                document.querySelector('.fp-translationFile')
            );

            FilePond.setOptions({
                server: {
                    process: {
                        url: '/contractor/translationUpload',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    }
                }
            });


            var table = $('#ordersTable').DataTable({
                scrollX: true,
                scrollCollapse: true,
                ordering: true,
                info: true,
                paging: true,
                fixedColumns: {
                    leftColumn: 1
                }
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
        });
    </script>
@endsection
