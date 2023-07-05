@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 mt-4">
    <!-- BEGIN: Vertical Form -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Assigning Translator for {{ $order->user->name }}'s Translation Order
            </h2>

        </div>
        <div id="vertical-form" class="p-5">
            <form action="{{ route('assign-contractor') }}" method="post">
                @csrf
                @method('POST')
                <div class="preview">
                    <div>
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
                                class="intro-x login__input form-control px-4 block" placeholder="Enter Total Payment"
                                value="">
                            <br>
                            <label for="amount" class="mt-2">Enter Rate</label>
                            <input type="number" name="rate" step="0.001"
                                class="mb-3 intro-x login__input form-control px-4 block mt-1 d-none" id="rate" value=""
                                placeholder="Enter Rate" value="">
                            <label for="amount" class="mt-2 mb-4">Enter Message</label>
                            <textarea type="number" id="message" name="message"
                                class="intro-x login__input mt-2 mb-2 form-control px-4 block" rows="3"
                                placeholder="Enter Message" value=""></textarea>
                            <label for="amount" class="mt-2 mb-2">Enter Translation Type</label>
                            <input type="text" name="translation_type"
                                class="intro-x login__input form-control px-4 block mt-2 d-none" id="translation_type"
                                value="" placeholder="Enter Translation Type (i.e Words, Page)"
                                value="{{$order->contractorOrder->translation_type}}">
                        </div>
                        <input type="submit" class="btn btn-primary mt-5" value="Send Email">
                    </div>
            </form>

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