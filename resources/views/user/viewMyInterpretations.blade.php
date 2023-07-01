@extends('user.layout')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">


    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                Interpretation Orders
            </h2>
        </div>

        <div class="intro-y box">
            <div id="vertical-form" class="p-5">
                <div class="preview">
                    <div>
                        <div class="overflow-x-auto">
                            <table id="myinterpretationsTable" class="table table-striped hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">Action</th>
                                        <th class="whitespace-nowrap">WO#</th>
                                        @if (Auth::user()->role_id == 2)
                                            <th class="whitespace-nowrap">Requester</th>
                                        @endif
                                        <th class="whitespace-nowrap">Session Date</th>
                                        <th class="whitespace-nowrap">Scheduled Time</th>
                                        <th class="whitespace-nowrap">Language</th>
                                        <th class="whitespace-nowrap">Session Format</th>
                                        <th class="whitespace-nowrap">Session Location</th>
                                        <th class="whitespace-nowrap">Session Title</th>
                                        <th class="whitespace-nowrap">Quote</th>
                                        <th class="whitespace-nowrap">Interpreter</th>
                                        <th class="whitespace-nowrap">Message</th>
                                        <th class="whitespace-nowrap">Created At</th>
                                        <th class="whitespace-nowrap">Status</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($interpretations as $interpretation)
                                        <tr>
                                            @if ($interpretation->is_cancelled == 0)
                                                <td class="whitespace-nowrap">
                                                    <div class="flex gap-1 items-center">
                                                        <div class="text-center mb-2 mr-1">
                                                            <a href="{{ route('view-interpretation-details', $interpretation->id) }}"
                                                                class="btn btn-primary"><svg
                                                                    class="w-5 h-5 text-black mx-auto"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="w-6 h-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                                                </svg></a>
                                                        </div>
                                                        @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 0)
                                                            <div class="text-center mb-2 mr-1">
                                                                <a href="{{ route('admin.interpretation.edit', $interpretation->id) }}"
                                                                    class="btn btn-warning"><svg
                                                                        class="w-5 h-5 text-white mx-auto"
                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" class="w-6 h-6">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        @endif
                                                        <div class="text-center mb-2 mr-1"> <a href="javascript:;"
                                                                data-tw-toggle="modal"
                                                                data-tw-target="#track-modal-preview{{ $interpretation->id }}"
                                                                title="Track" class="btn btn-success">
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

                                                        {{-- Modal --}}
                                                        <div id="track-modal-preview{{ $interpretation->id }}"
                                                            class="modal" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body p-0">
                                                                        <div class="p-5 text-center"> <i
                                                                                data-lucide="target"
                                                                                class="w-16 h-16 text-success mx-auto mt-3"></i>
                                                                            <div class="text-3xl mt-5">Track Interpretation
                                                                            </div>
                                                                        </div>
                                                                        <div class="intro-y box py-10 mt-5">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> <!-- END: Modal Content -->
                                                        <div class="text-center mb-2 mr-1">
                                                            <a href="{{ route('copy-interpretation-details', $interpretation->id) }}"
                                                                class="btn btn-pending"><svg
                                                                    class="w-4 h-4 text-white dark:text-white"
                                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 16 20">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M2 5a1 1 0 0 0-1 1v12a.969.969 0 0 0 .933 1h8.1a1 1 0 0 0 1-1.033M10 1v4a1 1 0 0 1-1 1H5m10-4v12a.97.97 0 0 1-.933 1H5.933A.97.97 0 0 1 5 14V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 9.828 1h4.239A.97.97 0 0 1 15 2Z" />
                                                                </svg></a>
                                                        </div>

                                                        @if ($interpretation->interpreter_id == null)
                                                            <div class="text-center mb-2 mr-1">
                                                                <form action="{{ route('cancelInterpretation') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="interpretation_id"
                                                                        value="{{ $interpretation->id }}">
                                                                    <button type="submit"
                                                                        class="btn bg-red-500 btn-danger">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="2.5" stroke="currentColor"
                                                                            class="w-5 h-5">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                        @if (
                                                            $interpretation->added_by_institute_user == 1 &&
                                                                $interpretation->interpreter_id === null &&
                                                                $interpretation->interpreter_completed == 0 &&
                                                                1 == 2)
                                                            <button class="btn btn-success mr-1 mb-2">Waiting for
                                                                Interpreter
                                                                <i data-loading-icon="three-dots" data-color="1a202c"
                                                                    class="w-4 h-4 ml-2"></i></button>
                                                        @elseif (
                                                            $interpretation->added_by_institute_user == 1 &&
                                                                $interpretation->interpreter_id != null &&
                                                                $interpretation->interpreter_completed == 0 &&
                                                                1 == 2)
                                                            <button class="btn btn-success mr-1 mb-2">Waiting for
                                                                Interpretation
                                                                <i data-loading-icon="three-dots" data-color="1a202c"
                                                                    class="w-4 h-4 ml-2"></i></button>
                                                        @elseif (
                                                            $interpretation->added_by_institute_user == 1 &&
                                                                $interpretation->interpreter_id != null &&
                                                                $interpretation->interpreter_completed == 1)
                                                            <button class="btn btn-success mr-1 mb-2">Interpretation
                                                                Completed</button>
                                                        @elseif (
                                                            $interpretation->wantQuote == 0 &&
                                                                $interpretation->invoiceSent == 0 &&
                                                                $interpretation->paymentStatus == 0 &&
                                                                1 == 2)
                                                            <button class="btn btn-warning mr-1 mb-2">Waiting for Invoice
                                                                <i data-loading-icon="three-dots" data-color="1a202c"
                                                                    class="w-4 h-4 ml-2"></i></button>
                                                        @elseif ($interpretation->wantQuote == 0 && $interpretation->invoiceSent == 1 && $interpretation->paymentStatus == 0)
                                                            <button class="btn btn-warning mr-1 mb-2">View Invoice</button>
                                                        @elseif (
                                                            $interpretation->wantQuote == 2 &&
                                                                $interpretation->invoiceSent == 1 &&
                                                                $interpretation->paymentStatus == 0 &&
                                                                $interpretation->interpreter_id === null &&
                                                                $interpretation->interpreter_completed == 0 &&
                                                                1 == 2)
                                                            <button class="btn btn-success mr-1 mb-2">Waiting for Payment
                                                                <i data-loading-icon="three-dots" data-color="1a202c"
                                                                    class="w-4 h-4 ml-2"></i></button>
                                                        @elseif (
                                                            $interpretation->wantQuote == 3 &&
                                                                $interpretation->invoiceSent == 1 &&
                                                                $interpretation->paymentStatus == 1 &&
                                                                $interpretation->interpreter_id == null &&
                                                                $interpretation->interpreter_completed == 0 &&
                                                                1 == 2)
                                                            <button class="btn btn-success mr-1 mb-2">Waiting for
                                                                Interpreter
                                                                <i data-loading-icon="three-dots" data-color="1a202c"
                                                                    class="w-4 h-4 ml-2"></i></button>
                                                        @elseif (
                                                            $interpretation->wantQuote == 3 &&
                                                                $interpretation->invoiceSent == 1 &&
                                                                $interpretation->paymentStatus == 1 &&
                                                                $interpretation->interpreter_id !== null &&
                                                                $interpretation->interpreter_completed == 0 &&
                                                                1 == 2)
                                                            <button class="btn btn-success mr-1 mb-2">Waiting for
                                                                Interpretation
                                                                <i data-loading-icon="three-dots" data-color="1a202c"
                                                                    class="w-4 h-4 ml-2"></i></button>
                                                        @elseif (
                                                            $interpretation->wantQuote == 0 &&
                                                                $interpretation->invoiceSent == 1 &&
                                                                $interpretation->paymentStatus == 1 &&
                                                                $interpretation->interpreter_id !== null &&
                                                                $interpretation->interpreter_completed == 1 &&
                                                                1 == 2)
                                                            <button class="btn btn-success mr-1 mb-2">Interpretation
                                                                Completed</button>
                                                        @elseif ($interpretation->wantQuote == 1 && Auth::user()->role_id != 2 && 1 == 2)
                                                            <button class="btn btn-warning mr-1 mb-2">Waiting for Quote <i
                                                                    data-loading-icon="three-dots" data-color="1a202c"
                                                                    class="w-4 h-4 ml-2"></i></button>
                                                        @elseif ($interpretation->wantQuote == 2 && Auth::user()->role_id != 2)
                                                            <a href="{{ route('viewQuoteInvoice', $interpretation->id) }}"
                                                                class="btn btn-warning mr-1 mb-2">View Quote & Pay</a>
                                                        @elseif (
                                                            $interpretation->wantQuote == 3 &&
                                                                $interpretation->paymentStatus == 1 &&
                                                                $interpretation->interpreter_id !== null &&
                                                                $interpretation->interpreter_completed == 0)
                                                            <button class="btn btn-success mr-1 mb-2">Waiting for
                                                                Interpretation
                                                                <i data-loading-icon="three-dots" data-color="1a202c"
                                                                    class="w-4 h-4 ml-2"></i></button>
                                                        @elseif (
                                                            $interpretation->wantQuote == 3 &&
                                                                $interpretation->paymentStatus == 1 &&
                                                                $interpretation->interpreter_id !== null &&
                                                                $interpretation->interpreter_completed == 1)
                                                            <button class="btn btn-warning mr-1 mb-2">Submit
                                                                Feedback</button>
                                                        @endif
                                                </td>
                                            @elseif($interpretation->is_cancelled == 1)
                                                <td class="whitespace-nowrap" style="font-weight: bold;">
                                                    <div class="flex justify-between gap-6 mx-auto items-center">
                                                        <span>Interpretation Cancelled</span>
                                                        @if ($interpretation->interpreter_id == null)
                                                            <div class="text-center mb-2 mr-1">
                                                                <form action="{{ route('cancelInterpretation') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="interpretation_id"
                                                                        value="{{ $interpretation->id }}">
                                                                    <button type="submit"
                                                                        class="btn bg-red-500 btn-danger">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-5 h-5">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </td>
                                            @endif

                                            <td class="whitespace-nowrap">{{ $interpretation->worknumber }}</td>
                                            @if (Auth::user()->role_id == 2)
                                                <td class="whitespace-nowrap">{{ $interpretation->user->email }}</td>
                                            @endif
                                            <td class="whitespace-nowrap">{{ $interpretation->interpretationDate }}</td>
                                            <td class="whitespace-nowrap">
                                                {{ App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->start_time) }}
                                                -
                                                {{ App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->end_time) }}
                                            </td>
                                            <td class="whitespace-nowrap">{{ $interpretation->language }}</td>
                                            {{-- Session Format --}}
                                            <td class="whitespace-nowrap">{{ $interpretation->session_format }}</td>
                                            {{-- Session Location --}}
                                            <td class="whitespace-nowrap">{{ $interpretation->location }}</td>
                                            {{-- Session Title --}}
                                            <td class="whitespace-nowrap">{{ $interpretation->session_topics }}</td>
                                            {{-- Quote --}}
                                            <td class="whitespace-nowrap">
                                                <a href="javascript:;" data-tw-toggle="modal"
                                                    data-tw-target="#note-modal-preview{{ $interpretation->id }}">
                                                    <i data-lucide="message-square" class="w-5 h-5 mr-2"> </i>
                                                </a>
                                            </td>
                                            <!-- BEGIN: Modal Content -->
                                            <div id="note-modal-preview{{ $interpretation->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="p-5 text-center"> <i data-lucide="bookmark"
                                                                    class="w-16 h-16 text-info mx-auto mt-3"></i>
                                                                <div class="text-3xl mt-5 mb-2">Interpretation Note</div>
                                                                <div class="w-full text-left">
                                                                    <label for="order-form-21" class="form-label">Quote
                                                                        Message:</label>
                                                                    <textarea id="order-form-21" type="text" class="form-control" disabled>{{ $interpretation->quote_description }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- END: Modal Content -->
                                            <td class="whitespace-nowrap">{{ $interpretation->interpreter->name ?? '-' }}
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
                                                {{ App\Helpers\HelperClass::convertDateToCurrentTimeZone($interpretation->created_at, request()->ip()) }}
                                            </td>
                                            <td class="whitespace-nowrap">
                                                @include('utils.interpretation-status-column', [
                                                    'interpretation' => $interpretation,
                                                ])
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/b-2.3.6/b-html5-2.3.6/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
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
            ordering: false,
            info: true,
            paging: true,
            pageLength: 10,
        });
        $(document).on('click', '.btn.btn-success', function() {
            var interpretationId = $(this).data('tw-target').replace('#track-modal-preview', '');
            console.log("Clicked Track", interpretationId);
            $.get('/user/interpretation/' + interpretationId + '/track', function(data) {
                $('.intro-y.box.py-10.mt-5').html(data);
            });
        });
    </script>
@endsection
