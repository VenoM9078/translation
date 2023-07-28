@extends('admin.layout')

@section('content')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js">
    </script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5 mb-4">
                Upload Translation File | WO#: {{ $order->worknumber }}
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
                    <div class="row">
                        <div class="col-8">
                            <form action="{{ route('admin.submit-translation-file') }}" method="post"
                                enctype="multipart/form-data" accept-charset="utf-8">
                                @csrf
                                @method('POST')
                                <textarea name="message" id="" class="form-control" placeholder="Type message (optional)"></textarea>
                                <input type="hidden" name="contractor_order_id" value="-1">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                {{-- <div class="col-span-8 p-2 sm:col-span-12"> --}}
                                <input type="file" id="fp-translationFile" class="filepond mt-2 fp-translationFile"
                                    name="translationFile" multiple data-max-files="1" data-max-file-size="10MB" />
                                <button type="submit" class="btn btn-success w-24">Submit</button>
                                {{-- </div> --}}
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

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
            document.querySelector('.fp-translationFile')
        );

        FilePond.setOptions({
            server: {
                process: {
                    url: '/upload-translation',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    ondata: (formData) => {
                        formData.append('order_id', document.querySelector('input[name="order_id"]').value);
                        return formData;
                    }
                }
            }
        });
    </script>
@endsection
