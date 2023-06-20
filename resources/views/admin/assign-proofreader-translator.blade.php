@extends('admin.layout')

@section('content')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />

    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
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
                @if (isset($message))
                    <div class="alert alert-success mt-3 mb-3">
                        <ul>
                            <li>{{ $message }}</li>
                        </ul>
                    </div>
                @endif
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
                    <form action="{{ route('assign-proofread-translator-submit') }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="tab-content mt-5">
                            {{-- Translator Tab --}}
                            <div id="translator" class="tab-pane leading-relaxed active" role="tabpanel"
                                aria-labelledby="translator-tab">
                                <div class="intro-x mt-4">
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div class="mt-1">
                                        <label for="amount" class="mt-2">Select Translator</label>
                                        <select data-placeholder="Select A Contractor" id="contractor_select"
                                            name="contractor_id" class="tom-select w-full">
                                            @foreach ($contractors as $contractor)
                                                @if ($contractor->id == $cOrder->contractor_id)
                                                    <option value="{{ $contractor->id }}" selected>{{ $contractor->name }}
                                                    </option>
                                                @endif
                                                <option value="{{ $contractor->id }}">{{ $contractor->name }}
                                                    (${{ $contractor->translation_rate }} / hour)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    {{-- <label for="amount">Enter total words</label>
                                    <input type="number" required id="total_words" name="total_words"
                                        class="intro-x login__input form-control px-4 block" placeholder="Enter Total Words"
                                        value="">
                                    <br> --}}
                                    <label for="amount" class="mt-2">Enter Translator Adjust ($)</label>
                                    <input type="number" step="0.001" name="t_adjust"
                                        class="intro-x login__input form-control px-4 block mt-1"
                                        placeholder="Enter Adjust Rate" value="{{ $cOrder->translator_adjust }}">
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
                                            value="{{ $cOrder->translation_due_date }}">
                                    </div>
                                    <br>
                                    <label for="amount" class="mt-2">Enter Rate</label>
                                    <input type="number" name="rate" step="0.001"
                                        class="mb-3 intro-x login__input form-control px-4 block mt-1 d-none" id="rate"
                                        value="" placeholder="Enter Rate" value="{{ $cOrder->rate }}">
                                    <br>

                                    <label for="amount" class="mt-2 mb-2">Enter Translation Type</label>
                                    <select data-placeholder="Enter Translation Type" name="translation_type"
                                        class="tom-select w-full">
                                        <option value="{{ $cOrder->translation_type }}" selected>
                                            {{ $cOrder->translation_type ?? '--' }} </option>
                                        <option value="By Word">By Word</option>
                                        <option value="By Page">By Page</option>
                                    </select>
                                    <br>
                                    <label for="amount" class="mt-2">Enter Unit</label>
                                    <input type="number" name="t_unit" step="0.001"
                                        class="mb-3 intro-x login__input form-control px-4 block mt-1 d-none" id="unit"
                                        value="" placeholder="Enter Unit" value="{{ $cOrder->translator_unit }}">
                                    <br>
                                    <label for="t_adjust_note">T. Adjust Note</label>
                                    <textarea id="t_adjust_note" name="translator_adjust_note"
                                        class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" placeholder="P. Adjust Note">{{ $cOrder->translator_adjust_note }}</textarea>
                                    <label for="amount" class="mt-2 mb-2">Paid</label>
                                    <select data-placeholder="Enter Translation Type" name="translator_paid"
                                        class="tom-select w-full">
                                        @if ($cOrder->translator_paid)
                                            <option value="{{ $cOrder->translator_paid }}" selected>
                                                {{ $cOrder->translator_paid == 1 ? 'Yes' : 'No' }}
                                        @endif
                                        </option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <br>
                                    <label for="amount" class="mt-2 mb-4">Enter Message</label>
                                    <textarea type="number" id="message" name="message"
                                        class="intro-x login__input mt-2 mb-2 form-control px-4 block" rows="3" placeholder="Enter Message"
                                        value="{{ $cOrder->message }}">{{ $cOrder->message }}</textarea>
                                </div>
                            </div>
                            {{-- Proof Reader Tab --}}
                            <div id="proofreader" class="tab-pane leading-relaxed" role="tabpanel"
                                aria-labelledby="proofreader-tab">
                                <div class="intro-x mt-4">
                                    <div class="mt-1">
                                        <label for="amount" class="mt-2">Select Proofreader</label>
                                        <select data-placeholder="Select A Contractor" name="p_contractor_id"
                                            class="tom-select w-full">
                                            <option value="{{ $pOrder->contractor_id }}" selected>
                                                {{ $pOrder->contractor->name }} </option>
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
                                    <input type="number" step="0.001" name="p_total_payment"
                                        class="intro-x login__input form-control px-4 block"
                                        placeholder="Enter Total Payment" value="{{ $pOrder->total_payment }}">
                                    <br>
                                    <label for="amount" class="mt-2">Enter Rate</label>
                                    <input type="number" step="0.001" name="p_rate"
                                        class="intro-x login__input form-control px-4 block mt-1" placeholder="Enter Rate"
                                        value="{{ $pOrder->p_rate }}">
                                    <div class="mt-5">
                                        <label for="">Enter Due Date</label>
                                        <input type="date" name="proof_read_due_date"
                                            class="intro-x login__input form-control py-3 px-4 block"
                                            value="{{ $pOrder->proof_read_due_date }}">
                                    </div>
                                    <br>
                                    <label for="amount" class="mt-4 mb-2">Enter ProofRead Type</label>
                                    <select data-placeholder="Enter ProofRead Type" name="p_type"
                                        class="tom-select w-full">
                                        <option value="{{ $pOrder->proofread_type }}" selected>
                                            {{ $pOrder->proofread_type ?? '-' }} </option>
                                        <option value="By Word">By Word</option>
                                        <option value="By Page">By Page</opation>
                                    </select>
                                    <br>

                                    <label for="amount" class="mt-2">Enter ProofRead Adjust ($)</label>
                                    <input type="number" step="0.001" name="p_adjust"
                                        class="intro-x login__input form-control px-4 block mt-1"
                                        placeholder="Enter Adjust Rate" value="{{ $pOrder->p_adjust }}">
                                    <br>
                                    <label for="amount" class="mt-2">Enter Unit</label>
                                    <input type="number" step="0.001" name="p_unit"
                                        class="intro-x login__input form-control px-4 block mt-1" placeholder="Enter Rate"
                                        value="{{ $pOrder->p_unit }}">
                                    <br>
                                    <label for="c_adjust_note">P. Adjust Note</label>
                                    <textarea id="p_adjust_note" name="p_adjust_note" class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                        placeholder="P. Adjust Note">{{ $pOrder->proof_read_adjust_note }}</textarea>
                                    <br>
                                    <label for="amount" class="mt-2 mb-2">Paid</label>
                                    <select data-placeholder="Enter Translation Type" name="proof_read_paid"
                                        class="tom-select w-full">
                                        @if ($pOrder->proof_read_paid != '')
                                            <option value="{{ $pOrder->proof_read_paid }}" selected>
                                                {{ $pOrder->proof_read_paid == 1 ? 'Yes' : 'No' }} </option>
                                        @else
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        @endif
                                    </select>
                                    <br>
                                    <label for="amount" class="mt-2 mb-4">Enter Message</label>
                                    <textarea type="number" id="message" name="p_message"
                                        class="intro-x login__input mt-2 mb-2 form-control px-4 block" rows="3" placeholder="Enter Message"
                                        value="{{ $pOrder->message }}">{{ $pOrder->message }}</textarea>
                                    <input type="file" id="multipleFiles" class="filepond mt-2" name="proofReadFile"
                                        data-max-file-size="10MB" />
                                    {{-- <div class="btn-group mt-4" role="group" aria-label="Basic example">
                                        <button type="submit" id="uploadBtn" class="btn btn-primary">Upload Files for
                                            Proof Read</button>
                                    </div> --}}
                                    {{-- <button type="submit" class="btn btn-success w-24">Submit</button> --}}
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary mt-5" id="submit_2" value="Assign">
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>


<script>
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
                    var total_words = $("#unit").val();
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

        $("#unit").change(function() {
            var total_words = $(this).val();
            var estimated_payment = calculateEstimatedPayment(total_words);
            $('#total_payment').val(estimated_payment);
        });
        //Filepond
        FilePond.registerPlugin(
            FilePondPluginFileEncode,
            FilePondPluginFileValidateSize
        );

        FilePond.create(
            document.querySelector('#multipleFiles')
        );

        FilePond.setOptions({
            server: {
                url: '/admin/upload-proof',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
    });
</script>
