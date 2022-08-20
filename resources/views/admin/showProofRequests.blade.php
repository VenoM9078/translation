@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">   
  
</div>
<div class="intro-y flex items-center h-10 mb-5 mt-2">
    <h2 class="text-lg font-medium truncate ml-2 mr-5">
        Proofreader Requests
    </h2>
</div>
<hr style="margin-bottom: 30px;">
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
                  <th class="whitespace-nowrap">Customer's Email</th>
                  <th class="whitespace-nowrap">Translator's Email</th>
                  <th class="whitespace-nowrap">Proofreader's Email</th>
                  <th class="whitespace-nowrap">Proofread Status</th>
                  <th class="whitespace-nowrap">Assigned At</th>
                  <th class="whitespace-nowrap">Actions</th>

              </tr>
          </thead>
          <tbody>
            @foreach ($proofReadRequests as $proofReadRequest)
              
              <tr>
                  <td class="whitespace-nowrap">{{ $proofReadRequest->order->worknumber }}</td>
                  <td class="whitespace-nowrap">{{ $proofReadRequest->order->user->email }}</td>
                  <td class="whitespace-nowrap">{{ $proofReadRequest->order->translationRequest->translator_email }}</td>
                  <td class="whitespace-nowrap">{{ $proofReadRequest->proofreader_email }}</td>

                  @if ($proofReadRequest->proofread_status == 1)
                  <td class="whitespace-nowrap"><button class="btn btn-rounded-success w-24 mr-1 mb-2">Done</button></td>
                  @else
                  <td class="whitespace-nowrap"><button class="btn btn-rounded-pending w-24 mr-1 mb-2">Pending</button></td>
                  @endif                  
                  <td class="whitespace-nowrap">{{ $proofReadRequest->created_at }}</td>
                  
                  {{-- {{ route('translator.edit', $translator->id) }} --}}
                  {{-- {{ route('translator.destroy', $translator->id) }} --}}
                  <td class="whitespace-nowrap">
                    <div class="flex  items-center">
                        {{-- <a href="{{ route('downloadFiles',$order->id) }}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="download" class="w-5 h-5"></i> </a> --}}
                        @if ($proofReadRequest->proofread_status == 0)
                        <a href="{{ route('changeProofReadRequestStatus',$proofReadRequest->order->id) }}" class="btn btn-warning mr-1 mb-2"> Mark as Completed </a>
                        {{-- <a href="{{ route('mailToTranslator',$translationRequest->order->id) }}" class="btn btn-primary mr-1 mb-2"> Send Mail Again </a> --}}
                        @else
                        <a href="{{ route('changeProofReadRequestStatus',$proofReadRequest->order->id) }}" class="btn btn-danger mr-1 mb-2"> Mark as Incomplete </a>
                        {{-- <a href="{{ route('mailToProofReader',$translationRequest->order->id) }}" class="btn btn-dark mr-1 mb-2"><i data-lucide="calendar" class="w-5 h-5 mr-2"></i> Mail to Proofreader </a> --}}

                        @endif
                        {{-- <form action="{{ route('invoice.destroy', $invoice->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <div> <button type="submit" class="btn btn-danger mb-2"><i data-lucide="trash" class="w-4 h-4"></i></button> </div> <!-- END: Modal Toggle -->
                        </form> --}}

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