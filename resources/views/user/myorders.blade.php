@extends('user.layout')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"/>

<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5 mb-5">
            Translation Center
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
                    <table id="myTable" class="table table-striped" style="width:100%">                        
                      <thead>
                            <tr>
                                <th class="whitespace-nowrap">Work Number</th>
                                <th class="whitespace-nowrap">Current Language</th>
                                <th class="whitespace-nowrap">Translated Language</th>
                                <th class="whitespace-nowrap">Payment Status</th>
                                <th class="whitespace-nowrap">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($user->orders as $order)
                            
                            <tr>
                                <td class="whitespace-nowrap">{{ $order->worknumber }}</td>
                                <td class="whitespace-nowrap">{{ $order->language1 }}</td>
                                <td class="whitespace-nowrap">{{ $order->language2 }}</td>
                                @if ($order->paymentStatus == 1)
                                <td class="whitespace-nowrap"><button class="btn btn-rounded-success w-24 mr-1 mb-2">Paid</button></td>
                                @else
                                <td class="whitespace-nowrap"><button class="btn btn-rounded-pending w-24 mr-1 mb-2">Pending</button></td>
                                @endif
                                <td class="whitespace-nowrap">
                                    <div>
                                        <a href="javascript:;" data-trigger="click" class="tooltip btn btn-primary" title="{{ $order->orderStatus }}">Show Status</a>
                                        @if (empty($order->invoice))
                                            
                                        @else
                                        <a href="{{ route('viewInvoice',$order->invoice->id) }}" data-trigger="click" class="tooltip btn btn-primary" title="{{ $order->orderStatus }}">View Invoice</a>
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
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" ></script>
<script type="text/javascript" src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
 $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>

<script>

    let button = document.querySelector('#uniqueModal');

    button.addEventListener('click', function() {
        let value = button.value;

        console.log(value);
    })

</script>

@endsection