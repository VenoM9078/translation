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
                                <th class="whitespace-nowrap">Order Status</th>
                                <th class="whitespace-nowrap">Possible Action</th>

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
                                    @if($order->invoiceSent == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">25%</div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-2/4 bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">50%</div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 1 && $order->proofread_status == 0)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-3/4 bg-pending" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">75%</div>
                                    </div>
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 1 && $order->proofread_status == 1)
                                    <div class="progress h-6">
                                        <div class="progress-bar w-4/4 bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">100%</div>
                                    </div>
                                    @endif
                
                                  </td>
                                {{-- <td class="whitespace-nowrap">
                                    <div>
                                        <a href="javascript:;" data-trigger="click" class="tooltip btn btn-primary" title="{{ $order->orderStatus }}">Show Status</a>
                                        @if (empty($order->invoice))
                                            
                                        @else
                                        <a href="{{ route('viewInvoice',$order->invoice->id) }}" data-trigger="click" class="tooltip btn btn-primary" title="{{ $order->orderStatus }}">View Invoice</a>
                                        @endif
                                    </div>
                                </td> --}}


                                <td class="whitespace-nowrap">
                                    @if($order->invoiceSent == 0)
                                    <button class="btn btn-warning mr-1 mb-2"> Waiting for Invoice <i data-loading-icon="three-dots" data-color="ffffff" class="w-4 h-4 ml-2"></i> </button>
                
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                                    <a href="{{ route('viewInvoice',$order->invoice->id) }}" class="btn btn-warning mr-1 mb-2"> View Invoice </a>
                
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 0)
                                    <button class="btn btn-primary mr-1 mb-2"> Waiting for Translation <i data-loading-icon="three-dots" data-color="1a202c" class="w-4 h-4 ml-2"></i> </button>
                
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 1 && $order->proofread_status == 0)
                                    <button class="btn btn-pending mr-1 mb-2"> Waiting for Proofreading <i data-loading-icon="three-dots" data-color="1a202c" class="w-4 h-4 ml-2"></i> </button>
                
                                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 1 && $order->proofread_status == 1 && $order->completed == 1)
                                    <a href="{{ route('downloadTranslatedForUser',$order->id) }}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="download" class="w-5 h-5 mr-2"> </i>Download Translated Files </a>
                
                                    @endif
                
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