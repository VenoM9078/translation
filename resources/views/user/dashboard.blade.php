@extends('user.layout')

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
        <h2 class="text-lg font-medium truncate mr-5">
            Translation Center
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
                    <form action="{{ route('user.store') }}" accept-charset="utf-8" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="intro-x mt-4">
                            <input type="text" id="language1" name="language1"
                                class="intro-x login__input form-control py-3 px-4 block" required
                                placeholder="Current Language of the Document" value="">
                            <input type="text" id="language2" name="language2"
                                class="intro-x login__input form-control py-3 px-4 block mt-4" required
                                placeholder="What Language does the Document needs to be Translated into?" value="">
                            <input type="text" name="access_code" id="access_code"
                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                placeholder="Access Code (for returning customers)" value="">
                            <input type="text" name="casemanager" id="casemanager" style="margin-bottom: 20px;"
                                class="intro-x login__input form-control py-3 px-4 block mt-4"
                                placeholder="Case Manager (optional)" value="">
                            <input type="file" id="multipleFiles" class="filepond" name="transFiles[]" multiple
                                data-max-file-size="10MB" data-max-files="15" />
                            <hr class="my-2 py-2">

                            <span style="color: rgb(185 28 28); margin-top: 20px; padding-top: 20px;"
                                class="mt-5 pt-5 text-red-600">
                                Looking to pay instantly and skip the hassle of waiting for a customized invoice? You
                                can now Pay Now by enabling the button below.
                            </span>

                            <div class="flex mt-5 ">
                                <div class="form-check form-switch mb-4">
                                    <input
                                        class="form-check-input appearance-none w-9 border-md justify-start border p-2 -ml-10 rounded-full float-left h-5 align-top bg-white bg-no-repeat bg-contain bg-gray-300 focus:outline-none cursor-pointer shadow-sm"
                                        type="checkbox" role="switch" id="flexSwitchCheckDefault" name="isPayNow">
                                    <label class="form-check-label inline-block text-black"
                                        for="flexSwitchCheckDefault">Pay Now</label>
                                    <br>
                                    <hr>
                                </div>
                            </div>

                        </div>

                        <div class="btn-group mt-5" role="group" aria-label="Basic example">

                            <button type="submit" id="uploadBtn" class="btn btn-primary">Upload Files for
                                Translation</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<!-- add before </body> -->
{{-- TODO:CHANGE Client id --}}
<script
    src="https://www.paypal.com/sdk/js?client-id=AapYCwr7IL6pstdnEZ8a8Ugv_WMX3qBJflHAfrlFwye5D-7oB22i8Nrky2_AwRLLLTayYkhWS21uKygn&disable-funding=credit&components=buttons">
</script>

<script>
    if ($("#flexSwitchCheckDefault").is(':checked') == false) {
            $("#paypal-button-container").hide();
        } else {
            $("#paypal-button-container").show();
        }
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
                url: '/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });


        order = 4
</script>
@endsection