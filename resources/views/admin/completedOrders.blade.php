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
                        <a href="{{ route('downloadTranslatedFiles',$order->id) }}" class="btn btn-warning mr-1 mb-2"> <i data-lucide="download" class="w-5 h-5 mr-2"> </i>Download Translated Files </a>
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