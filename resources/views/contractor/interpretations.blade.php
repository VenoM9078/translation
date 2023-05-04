@extends('contractor.layout')

@section('content')
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-5">
                All Pending Interpretations
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
                                        <th class="whitespace-nowrap">Description</th>
                                        <th class="whitespace-nowrap">Quantity (Words / Pages)</th>
                                        <th class="whitespace-nowrap">Amount</th>
                                        <th>Created At</th>
                                        <th class="whitespace-nowrap">Status</th>
                                        <th class="whitespace-nowrap">Possible Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($interpretations as $interpretation)
                                        <tr>
                                            <td class="whitespace-nowrap">{{ $interpretation->description }}</td>

                                            <td class="whitespace-nowrap">{{ $interpretation->docQuantity }}</td>
                                            <td class="whitespace-nowrap">${{ $interpretation->amount }}</td>

                                            <td class="whitespace-nowrap">
                                                {{ $interpretation->created_at->timezone('America/Los_Angeles') }}</td>
                                            <td class="whitespace-nowrap">
                                                <div>

                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap">
                                                <div class="flex gap-2">
                                                    @if ($interpretation->order->paymentStatus == 0)
                                                        <div><a href="{{ route('viewInvoice', $translation->id) }}"
                                                                class="btn btn-warning">View Invoice</a></div>
                                                    @endif
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
