@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">   
  
</div>

<div class="intro-y flex items-center h-10 mb-5 mt-2">
    <h2 class="text-lg font-medium truncate ml-2 mr-5">
        Pending Orders
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
                  <th class="whitespace-nowrap">Work Number</th>
                  <th class="whitespace-nowrap">Current Language</th>
                  <th class="whitespace-nowrap">Translated Language</th>
                  <th class="whitespace-nowrap">Payment Status</th>
                  <th class="whitespace-nowrap">Order Status</th>
                  <th class="whitespace-nowrap">Actions</th>
                  <th class="whitespace-nowrap">Next Step</th>

              </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
              
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
                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0 && $order->is_evidence == 1)
                    <div class="progress h-6">
                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">30%</div>
                    </div>
                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                    <div class="progress h-6">
                        <div class="progress-bar w-1/4" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>
                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 0)
                    <div class="progress h-6">
                        <div class="progress-bar w-2/4" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">50%</div>
                    </div>
                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 1 && $order->proofread_status == 0)
                    <div class="progress h-6">
                        <div class="progress-bar w-3/4" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">75%</div>
                    </div>
                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 1 && $order->proofread_status == 1)
                    <div class="progress h-6">
                        <div class="progress-bar w-4/4" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                    @endif

                  </td>
                  {{-- {{ route('translator.edit', $translator->id) }} --}}
                  {{-- {{ route('translator.destroy', $translator->id) }} --}}
                  <td class="whitespace-nowrap">
                    <div class="flex  items-center">
                        {{-- <a href="javascript:;" data-trigger="click" title="{{ $order->orderStatus }}" class="tooltip btn btn-primary mr-1 mb-2">Show Progress</a> --}}

                        <a href="{{ route('downloadFiles',$order->id) }}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="download" class="w-5 h-5"></i> </a>
                        
                        <form action="{{ route('destroy', $order->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <div> <button type="submit" class="btn btn-danger mb-2"><i data-lucide="trash" class="w-4 h-4"></i></button> </div> <!-- END: Modal Toggle -->
                        </form>

                    </div>  
                </td>

                <td class="whitespace-nowrap">
                    @if($order->invoiceSent == 0)
                    <a href="{{ route('invoice.customInvoice',$order->id) }}" class="btn btn-success mr-1 mb-2"> <i data-lucide="calendar" class="w-5 h-5 mr-2"></i> Send Invoice</a>

                    @elseif($order->invoiceSent == 1 && $order->paymentStatus == 0 && $order->is_evidence == 1)
                    <a href="{{ route('downloadEvidence',$order->id) }}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="mouse-pointer" class="w-5 h-5 mr-2"></i> Download Proof</a>
                    <a href="{{ route('approveEvidence',$order->id) }}" class="btn btn-success mr-1 mb-2"> <i data-lucide="thumbs-up" class="w-5 h-5"></i></a>
                    <a href="{{ route('rejectEvidence',$order->id) }}" class="btn btn-danger mr-1 mb-2"> <i data-lucide="thumbs-down" class="w-5 h-5"></i></a>


                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 0)
                    <button class="btn btn-warning mr-1 mb-2"> Waiting for Payment <i data-loading-icon="three-dots" data-color="1a202c" class="w-4 h-4 ml-2"></i> </button>

                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 0)
                    <a href="{{ route('mailToTranslator',$order->id) }}" class="btn btn-pending mr-1 mb-2"> <i data-lucide="mail" class="w-5 h-5 mr-2"></i> Mail to Translator </a>

                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 1 && $order->proofread_status == 0)
                    <a href="{{ route('mailToProofReader',$order->id) }}" class="btn btn-dark mr-1 mb-2"><i data-lucide="mail" class="w-5 h-5 mr-2"></i> Mail to Proofreader </a>

                    @elseif ($order->invoiceSent == 1 && $order->paymentStatus == 1 && $order->translation_status == 1 && $order->proofread_status == 1)
                    <a href="{{ route('mailOfCompletion',$order->id) }}" class="btn btn-success mr-1 mb-2"><i data-lucide="mail" class="w-5 h-5 mr-2"></i> Send Translation to User </a>

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
@endsection