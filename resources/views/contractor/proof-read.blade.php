@extends('contractor.layout')

@section('content')
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

        <div class="intro-y box">
            <div id="vertical-form" class="p-5">
                <div class="preview">
                    <div>
                        <div class="overflow-x-auto">
                            <table id="myTable" class="table table-striped hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">Order Worknumber</th>
                                        <th class="whitespace-nowrap">Order By</th>
                                        <th class="whitespace-nowrap">Order Status</th>
                                        <th class="whitespace-nowrap">User Email</th>
                                        <th class="whitespace-nowrap">Language #1</th>
                                        <th class="whitespace-nowrap">Language #2</th>
                                        <th class="whitespace-nowrap">Total Payment</th>
                                        <th class="whitespace-nowrap">Rate</th>
                                        <th>Created At</th>
                                        <th class="whitespace-nowrap">Possible Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proofReadData as $translation)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $translation->order->worknumber }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->user->name }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->orderStatus }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->user->email }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->language1 }}</td>
                                            <td class="whitespace-nowrap">{{ $translation->order->language2 }}</td>
                                            <td class="whitespace-nowrap">${{ $translation->total_payment }}</td>
                                            <td class="whitespace-nowrap">${{ $translation->rate }}</td>
                                            <td class="whitespace-nowrap">
                                                {{  App\Helpers\HelperClass::convertDateToCurrentTimeZone($translation->created_at, request()->ip()) }}</td>

                                            <td class="whitespace-nowrap">
                                                <div class="flex gap-2">
                                                    <div>
                                                        <a href="{{ route('contractor.downloadFiles', $translation->order->id) }}"
                                                            class="btn btn-warning">Download Original Document
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('contractor.download-translation-file', $translation->contractor->contractorOrders[0]->id) }}"
                                                            class="btn btn-success">Download Translated Document
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('contractor.view-proof-read-submission', $translation->id) }}"
                                                            class="btn btn-success">Submit File
                                                        </a>
                                                    </div>
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
    </div>
    <script>
        let button = document.querySelector('#uniqueModal');

        button.addEventListener('click', function() {
            let value = button.value;

            console.log(value);
        })
    </script>
@endsection
