@extends('admin.layout')

@section('content')
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

    </div>
    <div class="intro-y flex items-center h-10 mb-5 mt-2">
        <h2 class="text-lg font-medium truncate ml-2 mr-5">
            Invoices
        </h2>
    </div>
    <hr>
    <!-- BEGIN: Data List -->

    @if ($message = Session::get('message'))
        <div class="alert alert-success mt-3 mb-3">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                    <div class="overflow-x-auto">
                        <table id="myTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Name</th>
                                    <th class="whitespace-nowrap">Email</th>

                                    <th class="whitespace-nowrap">Case Manager</th>
                                    <th class="whitespace-nowrap">Access Code</th>
                                    <th class="whitespace-nowrap">Order Worknumber</th>
                                    <th class="whitespace-nowrap">User Email</th>
                                    <th class="whitespace-nowrap">Payment Status</th>
                                    <th class="whitespace-nowrap">Amount</th>
                                    <th>Created On</th>
                                    <th class="whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td class="whitespace-nowrap">{{ $invoice->order->user->name }}</td>
                                        <td class="whitespace-nowrap">{{ $invoice->order->user->email }}</td>

                                        @if ($invoice->order->casemanager == null && $invoice->order->access_code == '')
                                            <td class="whitespace-nowrap">N/A</td>
                                            <td class="whitespace-nowrap">N/A</td>
                                        @elseif($invoice->order->casemanager == null && $invoice->order->access_code != '')
                                            <td class="whitespace-nowrap">N/A</td>
                                            <td class="whitespace-nowrap">{{ $invoice->order->access_code }}</td>
                                        @elseif($invoice->order->access_code == '' && $invoice->order->casemanager != null)
                                            <td class="whitespace-nowrap">{{ $invoice->order->casemanager }}</td>
                                            <td class="whitespace-nowrap">N/A</td>
                                        @else
                                            <td class="whitespace-nowrap">{{ $invoice->order->casemanager }}</td>
                                            <td class="whitespace-nowrap">{{ $invoice->order->access_code }}</td>
                                        @endif

                                        <td class="whitespace-nowrap">{{ $invoice->order->worknumber }}</td>
                                        <td class="whitespace-nowrap">{{ $invoice->order->user->email }}</td>
                                        @if ($invoice->order->paymentStatus == 1)
                                            <td class="whitespace-nowrap"><button
                                                    class="btn btn-rounded-success w-24 mr-1 mb-2">Paid</button></td>
                                        @elseif ($invoice->order->paymentStatus == 2)
                                            <td class="whitespace-nowrap"><button
                                                    class="btn btn-rounded-warning w-28 mr-1 mb-2">Deferred Payment</button>
                                            </td>
                                        @else
                                            <td class="whitespace-nowrap"><button
                                                    class="btn btn-rounded-pending w-24 mr-1 mb-2">Pending</button></td>
                                        @endif
                                        <td class="whitespace-nowrap">${{ $invoice->amount }}</td>

                                        {{-- {{ route('translator.edit', $translator->id) }} --}}
                                        {{-- {{ route('translator.destroy', $translator->id) }} --}}
                                        <td>{{ $invoice->created_at->timezone('America/Los_Angeles') }}</td>
                                        <td class="whitespace-nowrap">
                                            <div class="flex gap-2 items-center">
                                                <a href="{{ route('invoice.edit', $invoice->id) }}"
                                                    class="btn btn-warning">
                                                    <i data-lucide="edit" class="w-5 h-5"></i> </a>

                                                <div class="text-center"> <a href="javascript:;" data-tw-toggle="modal"
                                                        data-tw-target="#delete-modal-preview"
                                                        class="btn btn-danger">Delete</a>
                                                </div>
                                                <div class="text-center"> <a
                                                        href="{{ route('generatePDFInvoice', $invoice->id) }}"
                                                        class="btn btn-primary">Download Invoice</a>
                                                </div>


                                            </div>
                                        </td>

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

                                                            <form action="{{ route('invoice.destroy', $invoice->id) }}"
                                                                method="post">
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
                                        </div>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
