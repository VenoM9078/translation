@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">   
  
</div>
<!-- BEGIN: Data List -->
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
    <table id="myTable" class="table table-striped" style="width:100%">                        
        <thead>
              <tr>
                  <th class="whitespace-nowrap">Work Number</th>
                  <th class="whitespace-nowrap">Customer Email</th>
                  <th class="whitespace-nowrap">Current Language</th>
                  <th class="whitespace-nowrap">Translated Language</th>
                  <th class="whitespace-nowrap">Order Status</th>
                  <th class="whitespace-nowrap">Actions</th>

              </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
              
              <tr>
                  <td class="whitespace-nowrap">{{ $order->worknumber }}</td>
                  <td class="whitespace-nowrap">{{ $order->user->email }}</td>

                  <td class="whitespace-nowrap">{{ $order->language1 }}</td>
                  <td class="whitespace-nowrap">{{ $order->language2 }}</td>
                  @if ($order->completed == 1)
                  <td class="whitespace-nowrap"><button class="btn btn-rounded-success w-24 mr-1 mb-2">Completed</button></td>
                  @else
                  <td class="whitespace-nowrap"><button class="btn btn-rounded-pending w-24 mr-1 mb-2">Incomplete</button></td>
                  @endif
                  
                  {{-- {{ route('translator.edit', $translator->id) }} --}}
                  {{-- {{ route('translator.destroy', $translator->id) }} --}}
                  <td class="whitespace-nowrap">
                    <div class="flex  items-center">
                        <a href="{{ route('downloadFiles',$order->id) }}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="download" class="w-5 h-5 mr-2"> Download Translated Files</i> </a>
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