@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">   
  
</div>
<!-- BEGIN: Data List -->

<div class="intro-y flex items-center h-10 mb-5 mt-2">
    <h2 class="text-lg font-medium truncate ml-2 mr-5">
        Translation Requests
    </h2>
</div>
<hr>

@if ($message = Session::get('message'))
        <div class="alert alert-success mt-3 mb-3">
            <p>{{ $message }}</p>
        </div>
    @endif
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    <table id="myTable" class="table table-striped" style="width:100%">                        
        <thead>
              <tr>
                  <th class="whitespace-nowrap">Order Worknumber</th>
                  <th class="whitespace-nowrap">Translator Email</th>
                  <th class="whitespace-nowrap">Translation Status</th>
                  <th class="whitespace-nowrap">Assigned At</th>
                  <th class="whitespace-nowrap">Actions</th>

              </tr>
          </thead>
          <tbody>
            @foreach ($translationRequests as $translationRequest)
              
              <tr>
                  <td class="whitespace-nowrap">{{ $translationRequest->order->worknumber }}</td>
                  <td class="whitespace-nowrap">{{ $translationRequest->translator_email }}</td>
                  @if ($translationRequest->translation_status == 1)
                  <td class="whitespace-nowrap"><button class="btn btn-rounded-success w-24 mr-1 mb-2">Translated</button></td>
                  @else
                  <td class="whitespace-nowrap"><button class="btn btn-rounded-pending w-24 mr-1 mb-2">Pending</button></td>
                  @endif                  
                  <td class="whitespace-nowrap">{{ $translationRequest->created_at }}</td>
                  
                  {{-- {{ route('translator.edit', $translator->id) }} --}}
                  {{-- {{ route('translator.destroy', $translator->id) }} --}}
                  <td class="whitespace-nowrap">
                    <div class="flex  items-center">
                        {{-- <a href="{{ route('downloadFiles',$order->id) }}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="download" class="w-5 h-5"></i> </a> --}}
                        @if ($translationRequest->translation_status == 0)
                        <a href="{{ route('changeTranslationRequestStatus',$translationRequest->order->id) }}" class="btn btn-warning mr-1 mb-2"> Mark as Completed </a>
                        <a href="{{ route('mailToTranslator',$translationRequest->order->id) }}" class="btn btn-primary mr-1 mb-2"> Send Mail Again </a>
                        @else
                        <a href="{{ route('changeTranslationRequestStatus',$translationRequest->order->id) }}" class="btn btn-danger mr-1 mb-2"> Mark as Incomplete </a>
                        <a href="{{ route('mailToProofReader',$translationRequest->order->id) }}" class="btn btn-dark mr-1 mb-2"><i data-lucide="calendar" class="w-5 h-5 mr-2"></i> Mail to Proofreader </a>

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
<!-- END: Data List -->
<!-- END: Pagination -->
</div>
@endsection