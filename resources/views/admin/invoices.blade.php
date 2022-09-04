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
                  <th class="whitespace-nowrap">Order Worknumber</th>
                  <th class="whitespace-nowrap">User Email</th>
                  <th class="whitespace-nowrap">Payment Status</th>
                  <th class="whitespace-nowrap">Amount</th>
                  <th class="whitespace-nowrap">Actions</th>

              </tr>
          </thead>
          <tbody>
            @foreach ($invoices as $invoice)
              
              <tr>
                  <td class="whitespace-nowrap">{{ $invoice->order->worknumber }}</td>
                  <td class="whitespace-nowrap">{{ $invoice->order->user->email }}</td>
                  @if ($invoice->order->paymentStatus == 1)
                  <td class="whitespace-nowrap"><button class="btn btn-rounded-success w-24 mr-1 mb-2">Paid</button></td>
                  @elseif ($invoice->order->paymentStatus == 2)
                  <td class="whitespace-nowrap"><button class="btn btn-rounded-warning w-28 mr-1 mb-2">Payment Later</button></td>
                  @else
                  <td class="whitespace-nowrap"><button class="btn btn-rounded-pending w-24 mr-1 mb-2">Pending</button></td>
                  @endif                  
                  <td class="whitespace-nowrap">${{ $invoice->amount }}</td>
                  
                  {{-- {{ route('translator.edit', $translator->id) }} --}}
                  {{-- {{ route('translator.destroy', $translator->id) }} --}}
                  <td class="whitespace-nowrap">
                    <div class="flex  items-center">
                        <a href="{{ route('invoice.edit',$invoice->id) }}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="edit" class="w-5 h-5"></i> </a>

                        <form action="{{ route('invoice.destroy', $invoice->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <div> <button type="submit" class="btn btn-danger mb-2"><i data-lucide="trash" class="w-4 h-4"></i></button> </div> <!-- END: Modal Toggle -->
                        </form>

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