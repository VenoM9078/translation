@extends('admin.layout')

@section('content')
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">

    </div>
    <div class="intro-y flex items-center h-10 mb-5 mt-2">
        <h2 class="text-lg font-medium truncate ml-2 mr-5">
            Completed Orders
        </h2>
    </div>
    <hr style="margin-bottom: 30px;">
    <!-- BEGIN: Data List -->
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
                                    <th class="whitespace-nowrap">Institute</th>
                                    <th class="whitespace-nowrap">Case Manager</th>
                                    <th class="whitespace-nowrap">Access Code</th>
                                    <th class="whitespace-nowrap">Work Number</th>
                                    <th class="whitespace-nowrap">Customer Email</th>
                                    <th class="whitespace-nowrap">Current Language</th>
                                    <th class="whitespace-nowrap">Translated Language</th>
                                    <th class="whitespace-nowrap">Order Status</th>
                                    <th class="whitespace-nowrap">Contractor Rate</th>
                                <th class="whitespace-nowrap">Translation Rate</th>
                                <th class="whitespace-nowrap">Total Words</th>
                                <th class="whitespace-nowrap">Translation Due Date</th>
                                <th class="whitespace-nowrap">Translation Type</th>
                                <th class="whitespace-nowrap">Total Payment</th>
                                <th class="whitespace-nowrap">Translation Note</th>
                                <th class="whitespace-nowrap">Proofread Due Date</th>
                                <th class="whitespace-nowrap">Proofread Rate</th>
                                <th class="whitespace-nowrap">Proofread Total Payment</th>
                                <th class="whitespace-nowrap">Proofread Note</th>
                                <th class="whitespace-nowrap">Proofread Type</th>
                                <th class="whitespace-nowrap">Invoice</th>
                                    <th class="whitespace-nowrap">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    {{-- @dd($order->user->access_code) --}}
                                    <tr>
                                        <td class="whitespace-nowrap">{{ $order->user->name }}</td>
                                        <td class="whitespace-nowrap">{{ $order->user->email }}</td>
                                        @if(count($order->user->institute) > 0)
                                            <td class="whitespace-nowrap">{{ $order->user->institute[0]->name}}</td>
                                            @else
                                            <td class="whitespace-nowrap">N/A</td>
                                        @endif
                                        @if ($order->casemanager == null && $order->access_code == '')
                                            <td class="whitespace-nowrap">N/A</td>
                                            <td class="whitespace-nowrap">N/A</td>
                                        @elseif($order->casemanager == null && $order->access_code != '')
                                            <td class="whitespace-nowrap">N/A</td>
                                            <td class="whitespace-nowrap">{{ $order->access_code }}</td>
                                        @elseif($order->access_code == '' && $order->casemanager != null)
                                            <td class="whitespace-nowrap">{{ $order->casemanager }}</td>
                                            <td class="whitespace-nowrap">N/A</td>
                                        @else
                                            <td class="whitespace-nowrap">{{ $order->casemanager }}</td>
                                            <td class="whitespace-nowrap">{{ $order->access_code }}</td>
                                        @endif

                                        <td class="whitespace-nowrap">{{ $order->worknumber }}</td>
                                        <td class="whitespace-nowrap">{{ $order->user->email }}</td>

                                        <td class="whitespace-nowrap">{{ $order->language1 }}</td>
                                        <td class="whitespace-nowrap">{{ $order->language2 }}</td>
                                        @if ($order->completed == 1)
                                            <td class="whitespace-nowrap"><button
                                                    class="btn btn-rounded-success w-24 mr-1 mb-2">Completed</button></td>
                                        @else
                                            <td class="whitespace-nowrap"><button
                                                    class="btn btn-rounded-pending w-24 mr-1 mb-2">Incomplete</button></td>
                                        @endif

                                        @if($order->contractorOrder)
                                            <td>${{$order->contractorOrder->contractor->translation_rate}}</td>
                                            <td>${{$order->contractorOrder->rate}}</td>
                                            <td>${{$order->contractorOrder->total_words}}</td>
                                            <td>{{$order->contractorOrder->translation_due_date}}</td>
                                            <td>{{$order->contractorOrder->translation_type}}</td>
                                            <td>${{$order->contractorOrder->total_payment}}</td>
                                            <td>{{$order->contractorOrder->message}}</td>
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
                                            <td>{{$order->proofReaderOrder->feedback}}</td>
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
                                        {{-- {{ route('translator.edit', $translator->id) }} --}}
                                        {{-- {{ route('translator.destroy', $translator->id) }} --}}
                                        <td class="whitespace-nowrap">
                                            <div class="flex  items-center">
                                                <a href="{{ route('downloadTranslatedFiles', $order->id) }}"
                                                    class="btn btn-warning mr-1 mb-2"> <i data-lucide="download"
                                                        class="w-5 h-5 mr-2"> </i>Download Translated Files </a>
                                            </div>
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
@endsection
