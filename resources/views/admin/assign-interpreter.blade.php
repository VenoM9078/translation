@extends('admin.layout')

@section('content')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <div class="intro-y col-span-12 mt-4">
        <!-- BEGIN: Vertical Form -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Assigning Interpreter for {{ $interpretation->user->name }}'s Interpretation Order | WO:
                    {{ $interpretation->worknumber }}
                </h2>

            </div>
            <div id="vertical-form" class="p-5">
                <form action="{{ route('assign-interpreter') }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="preview spaxy-y-4">
                        <div>
                            <div class="intro-x mt-4">
                                <div class="mt-1">
                                    <label>Select Contractor</label>
                                    <select id="contractor_select" data-placeholder="Select a language" name="contractor_id"
                                        required class="tom-select w-full mt-2">

                                        @foreach ($contractors as $contractor)
                                            <option value="{{ $contractor->id }}">{{ $contractor->name }}
                                                ({{ $contractor->email }})
                                                - ${{ $contractor->interpretation_rate }}/hr
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="interpretation_id" value="{{ $interpretation->id }}">
                                {{-- <div class="mt-4">
                                    <label>Enter Description of Interpretation</label>
                                    <textarea type="text" name="description" required class="intro-x login__input form-control py-3 px-4 block mt-1"
                                        placeholder="Enter Interpretation Description" value=""></textarea>
                                </div> --}}

                                <div class="mt-2 w-full">
                                    <label for="c_fee">I. Rate ($)</label>
                                    <input type="number" step="0.01" id="i_rate" name="interpretation_rate"
                                        class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                        @if ($interpretation->contractorInterpretation) placeholder="Interpretation Rate ($)"
                                            @else
                                                placeholder="Interpreter not assigned" @endif
                                        value="{{ $interpretation->contractorInterpretation->per_hour_rate ?? '' }}">
                                </div>


                                <div class="mt-4">
                                    <label>I. Fee</label>
                                    <input type="number" name="i_fee" id="i_fee" step="0.01" required
                                        class="intro-x login__input form-control py-3 px-4 block mt-1"
                                        placeholder="Enter Interpretation Adjust"
                                        value="{{ $interpretation->contractorInterpretation->per_hour_rate ?? 0 }}">
                                </div>
                                <div class="mt-5 mb-5">
                                    <label>Enter I. Adjust</label><br>
                                    <small class="session-duration">Session Duration: </small>
                                    <input id="i_adjust" step="0.0001" type="number" required name="i_adjust"
                                        class="intro-x login__input form-control py-3 px-4 block mt-1"
                                        placeholder="Enter Estimated Payment (in dollars)"
                                        value="{{ $interpretation->contractorInterpretation->estimated_payment ?? 0 }}">
                                </div>
                                {{-- <div class="mt-3 mb-3">
                                    <label>Change Per Hour Rate</label>
                                    <input id="per_hour_rate" step="0.0001" type="number" name="per_hour_rate"
                                        class="intro-x login__input form-control py-3 px-4 block mt-1"
                                        placeholder="(Optional)" value="">
                                </div> --}}
                                <label for="c_adjust_note">Interpreter Message</label>
                                <textarea id="p_adjust_note" name="message_by_admin" class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4"
                                    placeholder="Type Message">{{ $interpretation->message_by_admin ?? '' }}</textarea>
                                <br>
                                <label for="c_adjust_note">I. Adjust Note</label>
                                <textarea id="p_adjust_note" name="interpreter_adjust_note"
                                    class="intro-x login__input form-control py-3 px-4 block mt-4 mb-4" placeholder="I. Adjust Note">{{ $interpretation->interpreter_adjust_note }}</textarea>
                                <br>
                                <label for="amount" class="mt-2 mb-2">I Paid</label>
                                <select data-placeholder="Enter Paid" name="interpreter_paid" class="tom-select w-full">
                                    @if ($interpretation->interpreter_paid)
                                        <option value="0"
                                            {{ $interpretation->interpreter_paid == 0 ? 'selected' : '' }}>
                                            No</option>
                                        <option value="1"
                                            {{ $interpretation->interpreter_paid == 1 ? 'selected' : '' }}>
                                            Yes</option>
                                    @else
                                        <option value="0" selected>
                                            No</option>
                                        <option value="1">
                                            Yes</option>
                                    @endif
                                </select>
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
            var sT = "{{ $interpretation->start_time }}";
            var eT = "{{ $interpretation->end_time }}";

            var startTime = new Date("1970-01-01 " + sT);
            var endTime = new Date("1970-01-01 " + eT);

            var differenceInMilliseconds = endTime.getTime() - startTime.getTime();
            var hours = differenceInMilliseconds / (1000 * 60 * 60);

            var differenceInMinutes = differenceInMilliseconds / (1000 * 60);
            var hours2 = Math.floor(differenceInMinutes / 60);
            var minutes = Math.floor(differenceInMinutes % 60);

            var durationDisplay;
            if (hours2 < 1) {
                durationDisplay = differenceInMinutes.toFixed(0) + ' minute(s)';
            } else {
                durationDisplay = hours2 + ' hr ' + minutes + ' min';
            }

            document.querySelector('.session-duration').textContent = 'Session Duration: ' + durationDisplay;

            function calculateEstimatedPayment(rate, adjust, duration) {
                // Round up the session hours to the nearest 0.25
                console.log(duration);
                var sessionHours = Math.ceil(duration * 4) / 4;

                // If the session hours are less than 1, set them to 1
                if (sessionHours < 1) {
                    sessionHours = 1;
                }
                console.log("session hour", sessionHours)
                return Math.abs(sessionHours * rate) + parseFloat(adjust);
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
                        var adjust = $("#i_adjust").val();
                        var estimated_payment = calculateEstimatedPayment(rate, adjust, hours);
                        $('#i_fee').val(estimated_payment);
                        $('#i_rate').val(rate);
                    }
                });
            }).change();

            $('#i_rate, #i_adjust').change(function() {
                var rate = $(this).val();
                var adjust = $("#i_adjust").val();
                var estimated_payment = calculateEstimatedPayment(rate, adjust, hours);
                $('#i_fee').val(estimated_payment);
            });
        });
    </script>
@endsection
