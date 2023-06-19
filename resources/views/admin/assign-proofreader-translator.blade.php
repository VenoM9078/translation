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

    <div class="intro-y col-span-12 mt-4">
        <!-- BEGIN: Vertical Form -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Assigning Translator for {{ $order->user->name }}'s Translation Order
                </h2>
            </div>
            <div id="vertical-form" class="p-5">

                <div class="container mt-8">
                    <ul class="nav nav-boxed-tabs" role="tablist">
                        <li id="translator-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#translator"
                                type="button" role="tab" aria-controls="translator"
                                aria-selected="true">Translator</button>
                        </li>
                        <li id="proofreader-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#proofreader"
                                type="button" role="tab" aria-controls="proofreader"
                                aria-selected="false">Proofreader</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-5">

                        <div id="translator" class="tab-pane leading-relaxed active" role="tabpanel"
                            aria-labelledby="translator-tab">
                            <form action="{{ route('assign-proofread-translator-submit') }}" method="post">
                                @csrf
                                @method('POST')
                                <div class="intro-x mt-4">
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div class="mt-1">
                                        <label for="amount" class="mt-2">Select Translator</label>
                                        <select data-placeholder="Select A Contractor" id="contractor_select" required
                                            name="contractor_id" class="tom-select w-full">
                                            <option value="-1" selected disabled>--</option>
                                            @foreach ($contractors as $contractor)
                                                <option value="{{ $contractor->id }}">{{ $contractor->name }}
                                                    (${{ $contractor->translation_rate }} / hour)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <label for="amount">Enter total words</label>
                                    <input type="number" required id="total_words" name="total_words"
                                        class="intro-x login__input form-control px-4 block" placeholder="Enter Total Words"
                                        value="">
                                    <br>
                                    <label for="amount" class="mt-2">Total Payment</label>
                                    <input type="number" id="total_payment" readonly name="total_payment"
                                        class="intro-x login__input form-control px-4 block"
                                        placeholder="Enter Total Payment" value="{{ $cOrder->total_payment }}">
                                    <br>
                                    <div class="mt-5">
                                        <label for="">Enter Due Date</label>
                                        <input type="date" name="translation_due_date"
                                            class="intro-x login__input form-control py-3 px-4 block"
                                            value="{{ $cOrder->translation_due_date }}" required>
                                    </div>
                                    <br>
                                    <label for="amount" class="mt-2">Enter Rate</label>
                                    <input type="number" name="rate" step="0.001"
                                        class="mb-3 intro-x login__input form-control px-4 block mt-1 d-none" id="rate"
                                        value="" placeholder="Enter Rate" value="{{ $cOrder->contractor->rate }}">
                                    <br>

                                    <label for="amount" class="mt-2 mb-4">Enter Message</label>
                                    <textarea type="number" id="message" name="message" class="intro-x login__input mt-2 mb-2 form-control px-4 block"
                                        rows="3" placeholder="Enter Message" value="{{ $cOrder->message }}"></textarea>
                                    <label for="amount" class="mt-2 mb-2">Enter Translation Type</label>
                                    <select data-placeholder="Enter Translation Type" required name="translation_type"
                                        class="tom-select w-full">
                                        <option value="-1" selected disabled> -- </option>
                                        <option value="By Word">By Word</option>
                                        <option value="By Page">By Page</option>
                                    </select>
                                    <br>
                                    <label for="amount" class="mt-2">Enter Unit</label>
                                    <input type="number" name="rate" step="0.001"
                                        class="mb-3 intro-x login__input form-control px-4 block mt-1 d-none"
                                        id="rate" value="" placeholder="Enter Unit"
                                        value="{{ $cOrder->translator_unit }}">
                                    <br>
                                    <label for="t_adjust_note">T. Adjust Note</label>
                                    <textarea id="t_adjust_note" name="translator_adjust_note"
                                        class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" placeholder="P. Adjust Note">{{ $cOrder->translator_adjust_note }}</textarea>
                                    <br>
                                    <label for="amount" class="mt-2 mb-2">Paid</label>
                                    <select data-placeholder="Enter Translation Type" required name="translator_paid"
                                        class="tom-select w-full">
                                        <option value="" selected disabled> -- </option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <input type="submit" class="btn btn-primary mt-5" id="submit_1" value="Send Email">
                            </form>
                        </div>
                        <div id="proofreader" class="tab-pane leading-relaxed" role="tabpanel"
                            aria-labelledby="proofreader-tab">
                            <form action="{{ route('assign-proofread-translator-submit') }}" method="post">
                                @csrf
                                @method('POST')
                                <div class="intro-x mt-4">
                                    <div class="mt-1">
                                        <label for="amount" class="mt-2">Select Proofreader</label>
                                        <select data-placeholder="Select A Contractor" required name="p_contractor_id"
                                            class="tom-select w-full">
                                            <option value="{{ $cOrder->id }}" selected>
                                                {{ $cOrder->contractor->name }} </option>
                                            @foreach ($contractors as $contractor)
                                                <option value="{{ $contractor->id }}">{{ $contractor->name }}
                                                    (${{ $contractor->translation_rate }} / hour)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <label for="amount" class="mt-4">Enter Fee</label>
                                    <input type="number" step="0.001" required name="p_total_payment"
                                        class="intro-x login__input form-control px-4 block"
                                        placeholder="Enter Total Payment" value="{{ $pOrder->total_payment }}">
                                    <br>
                                    <label for="amount" class="mt-2">Enter Rate</label>
                                    <input type="number" step="0.001" required name="p_rate"
                                        class="intro-x login__input form-control px-4 block mt-1" placeholder="Enter Rate"
                                        value="">
                                    <br>
                                    <label for="amount" class="mt-4 mb-2">Enter ProofRead Type</label>
                                    <select data-placeholder="Enter ProofRead Type" required name="p_type"
                                        class="tom-select w-full">
                                        <option value="-1" selected disabled> -- </option>
                                        <option value="By Word">By Word</option>
                                        <option value="By Page">By Page</option>
                                    </select>
                                    <br>
                                    <label for="amount" class="mt-2">Enter Unit</label>
                                    <input type="number" step="0.001" required name="p_unit"
                                        class="intro-x login__input form-control px-4 block mt-1" placeholder="Enter Unit"
                                        value="">
                                    <br>
                                    <label for="amount" class="mt-2">Enter ProofRead Adjust ($)</label>
                                    <input type="number" step="0.001" required name="p_adjust"
                                        class="intro-x login__input form-control px-4 block mt-1"
                                        placeholder="Enter Adjust Rate" value="">
                                    <br>
                                    <label for="amount" class="mt-2">Enter Unit</label>
                                    <input type="number" step="0.001" required name="p_unit"
                                        class="intro-x login__input form-control px-4 block mt-1" placeholder="Enter Rate"
                                        value="">
                                    <br>
                                    <label for="c_adjust_note">P. Adjust Note</label>
                                    <textarea id="p_adjust_note" name="p_adjust_note" class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                        placeholder="P. Adjust Note">{{ $pOrder->proof_read_adjust_note }}</textarea>
                                </div>
                                <input type="submit" class="btn btn-primary mt-5" id="submit_2" value="Send Email">
                            </form>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
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
                url: '/contractor/translationUpload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            }
        }
    });
    $(document).ready(function() {
        var rate = 0;

        function calculateEstimatedPayment(words) {
            return words * rate;
        }

        $('#contractor_select').change(function() {
            var contractor_id = $(this).val();
            $.ajax({
                url: "{{ route('get.translator.rate') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": contractor_id
                },
                success: function(data) {
                    rate = data.translation_rate;
                    var total_words = $("#total_words").val();
                    //if total words is empty then set total payment to 0
                    if (total_words == "") {
                        total_words = 0;
                    }
                    var estimated_payment = calculateEstimatedPayment(total_words);
                    $('#total_payment').val(estimated_payment);
                    $('#rate').val(rate); // set rate to rate field
                }
            });
        }).change(); // Trigger the change event manually to set the initial values

        $("#rate").change(function() {
            var total_words = $("#total_words").val();
            rate = $(this).val(); // use newly entered rate for calculation
            var estimated_payment = calculateEstimatedPayment(total_words);
            $('#total_payment').val(estimated_payment);
        });

        $("#total_words").change(function() {
            var total_words = $(this).val();
            var estimated_payment = calculateEstimatedPayment(total_words);
            $('#total_payment').val(estimated_payment);
        });
    });
</script>
