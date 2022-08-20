@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-4 mb-4">   
  
</div>
<div class="intro-y flex items-center h-10 mb-5 mt-2">
    <h2 class="text-lg font-medium truncate ml-2 mr-5">
        Quote Requests
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
                  <th class="whitespace-nowrap">Name</th>
                  <th class="whitespace-nowrap">Email</th>
                  <th class="whitespace-nowrap">Message</th>

              </tr>
          </thead>
          <tbody>
            @foreach ($quotes as $quote)
              
              <tr>
                  <td class="whitespace-nowrap">{{ $quote->name }}</td>
                  <td class="whitespace-nowrap">{{ $quote->email }}</td>
                  <td class="whitespace-nowrap">{{ $quote->message }}</td>

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