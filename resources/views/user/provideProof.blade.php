@extends('user.layout')

@section('content')

<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet"
/>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>



<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">
            Provide Evidence of Payment for Order ({{ $order->worknumber }})
        </h2>
    </div>

    @if ($message = Session::get('message'))
        <div class="alert alert-success mt-3">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="alert alert-primary show flex items-start mb-4 mt-4" role="alert"> Once submitted - your payment proof will be examined by our team. Please be patient in the process! </div>

    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                  <form action="{{ route('processProof') }}" accept-charset="utf-8" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="intro-x mt-4">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="file" id="multipleFiles" class="filepond" name="transFiles[]" data-max-file-size="10MB" />
                         
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Evidence</button> 

                    {{-- <div class="btn-group mt-5" role="group" aria-label="Basic example" style="margin-top: 3rem;">
                    
                    </div> --}}
                  
                </form>
                </div>
            </div>
           
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script>
  FilePond.registerPlugin(
    
    // encodes the file as base64 data
    FilePondPluginFileEncode,
    
    // validates the size of the file
    FilePondPluginFileValidateSize,
    
    // corrects mobile image orientation
    FilePondPluginImageExifOrientation,
    
    // previews dropped images
    FilePondPluginImagePreview
  );
  
  // Select the file input and use create() to turn it into a pond
  FilePond.create(
    document.querySelector('#multipleFiles')
  );
  
  FilePond.setOptions({
    server: {
      url: '/uploadProof',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
      
    }
  });
  
  
  </script>
@endsection