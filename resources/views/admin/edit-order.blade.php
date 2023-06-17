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
            <h2 class="text-lg font-medium truncate mr-5">
                Edit Order
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
                        <form action="{{ route('admin.edit-order') }}" accept-charset="utf-8" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="intro-x mt-4">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <label class="mt-2" for="">Current Language of the Document</label>
                                <input type="text" id="language1" name="language1"
                                    class="intro-x login__input form-control py-3 mt-2 px-4 block" required
                                    placeholder="Current Language of the Document" value="{{ $order->language1 }}">
                                <br>
                                <label for="">What Language does the Document needs to be Translated into?</label>
                                <input type="text" id="language2" name="language2"
                                    class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" required
                                    placeholder="What Language does the Document needs to be Translated into?"
                                    value="{{ $order->language2 }}">

                                <label for="contractor_name mt-4">Contractor Name</label>
                                @if ($order->translationStatus == 1 && $order->contractorOrder->is_accepted == 1)
                                    <input type="text" name="contractor_name" disabled id="contractor_name"
                                        style="margin-bottom: 20px;"
                                        class="intro-x login__input form-control py-3 px-4 block mt-4"
                                        placeholder="Contractor Name"
                                        value="{{ isset($order->contractorOrder->contractor->name) ? $order->contractorOrder->contractor->name : 'N/A' }}">
                                    <a href="{{ route('view-assign-proofreader', $order->id) }}"
                                        class="mb-2 btn btn-primary">Re-Assign ProofReader</a>
                                    <hr class="my-2 py-2">
                                @else
                                    <input type="text" name="contractor_name" disabled id="contractor_name"
                                        style="margin-bottom: 20px;"
                                        class="intro-x login__input form-control py-3 px-4 block mt-4"
                                        placeholder="Contractor Name"
                                        value="{{ isset($order->contractorOrder->contractor->name) ? $order->contractorOrder->contractor->name : 'N/A' }}">
                                    @if (isset($order->contractorOrder->contractor->name))
                                        <a href="{{ route('view-assign-contractor', $order->id) }}"
                                            class="mb-2 btn btn-primary">Re-Assign Contractor</a>
                                    @endif
                                @endif
                                <hr class="my-2 py-2">
                                <div class="flex gap-2 w-full">
                                    <div class="w-full">
                                        <label for="c_unit">Unit</label>
                                        <input type="number" id="unit" name="unit"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" required
                                            placeholder="Unit" value="{{ $order->unit }}">
                                    </div>
                                </div>
                                <div class="flex gap-2 w-full">

                                    <!-- C. Type field -->
                                    <div class="w-full">
                                        <label for="c_type">C. Type</label>
                                        <input type="text" id="c_type" name="c_type"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" required
                                            placeholder="C. Type" value="{{ $order->c_type }}">
                                    </div>

                                    <!-- C. Unit field -->
                                    <div class="w-full">
                                        <label for="c_unit">C. Unit</label>
                                        <input type="number" id="c_unit" name="c_unit"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" required
                                            placeholder="C. Unit" value="{{ $order->c_unit }}">
                                    </div>

                                </div>
                                <div class="flex gap-2 w-full">

                                    <!-- C. Rate field -->
                                    <div class="w-full">

                                        <label for="c_rate">C. Rate ($/W or $/P)</label>
                                        <input type="number" step="0.01" id="c_rate" name="c_rate"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" required
                                            placeholder="C. Rate ($/W or $/P)" value="{{ $order->c_rate }}">
                                    </div>
                                    <!-- C. Adjust field -->
                                    <div class="w-full">

                                        <label for="c_adjust">C. Adjust ($)</label>
                                        <input type="number" step="0.01" id="c_adjust" name="c_adjust"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" required
                                            placeholder="C. Adjust ($)" value="{{ $order->c_adjust }}">
                                    </div>
                                </div>

                                <div class="flex gap-2 w-full">

                                    <!-- C. Paid field -->
                                    <div class="w-full">
                                        <label for="c_paid">C. Paid</label>
                                        <select id="c_paid" name="c_paid"
                                            class="form-control py-3 px-4 block mt-4 mb-4" required>
                                            <option value="0" {{ $order->c_paid == 0 ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $order->c_paid == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                        </select>
                                    </div>
                                    <!-- C. Fee field -->
                                    <div class="w-full">

                                        <label for="c_fee">C. Fee ($)</label>
                                        <input type="number" step="0.01" id="c_fee" name="c_fee"
                                            class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" required
                                            placeholder="C. Fee ($)" value="{{ $order->c_fee }}">
                                    </div>
                                </div>
                                <!-- C. Adjust Note field -->
                                <label for="c_adjust_note">C. Adjust Note</label>
                                <textarea id="c_adjust_note" name="c_adjust_note" class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                    placeholder="C. Adjust Note">{{ $order->c_adjust_note }}</textarea>


                            </div>
                            <div class="btn-group mt-5" role="group" aria-label="Basic example">
                                <button type="submit" class="btn btn-primary">Edit Order</button>
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
