@extends('admin.layout')

@section('content')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js">
    </script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <div class="col-span-12 mt-8">
        <div class="intro-y flex items-center h-10">
            <h2 class="text-lg font-medium truncate mr-5">
                Submit Quote
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
                        <form action="{{ route('admin.submitOrderQuote') }}" accept-charset="utf-8" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="intro-x mt-4">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <div>
                                    <label for="">Enter a Quote</label>
                                    <input type="number" name="quote_price" step="0.00001"
                                        class="intro-x login__input form-control py-3 px-4 block" required
                                        placeholder="Enter a Quote in Dollars i.e 150">
                                </div>
                                <div class="mt-5">
                                    <label for="">Enter Quote Description</label>
                                    <textarea name="quote_description" class="intro-x login__input form-control py-3 px-4 block mt-4 h-30"
                                        placeholder="Enter Quote Description i.e mention what's included for the customer in this price."></textarea>
                                </div>
                                <div class="mt-5">
                                    <label for="">Upload Quote PDF</label>
                                    <input type="file" accept=".pdf,.docx" id="multipleFiles" class="filepond"
                                        name="quoteFile" data-max-file-size="20MB" data-max-files="15" />
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-5">Send Quote</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        FilePond.registerPlugin(

            // encodes the file as base64 data
            FilePondPluginFileEncode,

            // validates the size of the file
            FilePondPluginFileValidateSize,

            // corrects mobile image orientation
            FilePondPluginImageExifOrientation,

            // previews dropped images
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType
        );

        // Select the file input and use create() to turn it into a pond
        FilePond.create(
            document.querySelector('#multipleFiles')
        );

        FilePond.setOptions({
            acceptedFileTypes: ['application/pdf'],
            server: {
                url: '/admin/quote/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
    </script>
@endsection
