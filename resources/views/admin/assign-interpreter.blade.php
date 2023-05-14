@extends('admin.layout')

@section('content')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<div class="intro-y col-span-12 mt-4">
    <!-- BEGIN: Vertical Form -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
                Assigning Interpreter for {{ $interpretation->user->name }}'s Interpretation Order
            </h2>

        </div>
        <div id="vertical-form" class="p-5">
            <form action="{{ route('assign-interpreter') }}" method="post">
                @csrf
                @method('POST')
                <div class="preview">
                    <div>
                        <div class="intro-x mt-4">
                            <input type="hidden" name="interpretation_id" value="{{ $interpretation->id }}">
                            <div class="mb-3">
                                <label>Enter Description of Interpretation</label>
                                <textarea type="text" name="description" required
                                    class="intro-x login__input form-control py-3 px-4 block mt-1"
                                    placeholder="Enter Interpretation Description" value=""></textarea>
                            </div>

                            <div class="mt-3">
                                <label>Select Contractor</label>
                                <select id="contractor_select" data-placeholder="Select a language" name="contractor_id"
                                    required class="tom-select w-full mt-2">

                                    @foreach ($contractors as $contractor)
                                    <option value="{{ $contractor->id }}">{{ $contractor->name }}
                                        ({{ $contractor->email }}) - ${{ $contractor->interpretation_rate }}/hr
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-5 mb-5">
                                <label>Enter Estimated Payment</label><br>
                                <small>Session Duration: {{((int)$interpretation->end_time -
                                    (int)$interpretation->start_time)}} hour(s)</small>
                                <input id="estimated_payment" type="number" required name="estimated_payment"
                                    class="intro-x login__input form-control py-3 px-4 block mt-1"
                                    placeholder="Enter Estimated Payment (in dollars)" value="0">
                            </div>

                            <div class="mt-3 mb-3">
                                <label>Change Per Hour Rate</label>
                                <input id="per_hour_rate" type="number" required name="per_hour_rate"
                                    class="intro-x login__input form-control py-3 px-4 block mt-1"
                                    placeholder="(Optional)" value="">
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary mt-5" value="Assign Interpretation">
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var hours = {{ (int)$interpretation->end_time - (int)$interpretation->start_time }};
        
        function calculateEstimatedPayment(rate) {
            return hours * rate;
        }
        
        $('#contractor_select').change(function() {
            var contractor_id = $(this).val();
            $.ajax({
                url: "{{ route('get.contractor.rate') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": contractor_id
                },
                success: function(data) {
                    var rate = data.interpretation_rate;
                    var estimated_payment = calculateEstimatedPayment(rate);
                    $('#estimated_payment').val(estimated_payment);
                    $('#per_hour_rate').val(rate);
                }
            });
        }).change(); // Trigger the change event manually to set the initial values
        
        $('#per_hour_rate').change(function() {
            var rate = $(this).val();
            var estimated_payment = calculateEstimatedPayment(rate);
            $('#estimated_payment').val(estimated_payment);
        });
    });
</script>
@endsection