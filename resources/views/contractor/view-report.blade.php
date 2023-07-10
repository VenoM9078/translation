@extends('contractor.layout')

@section('content')
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">
            Report Interpretation
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
                    <form action="{{ route('contractor.report-submission') }}" accept-charset="utf-8" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="intro-x mt-4 space-y-2">
                            <input type="hidden" name="contractor_interpretation_id" value="{{ $interpretation->id }}">
                            <div class="mb-5">
                                <label class="mb-3 pb-3" for="">When did the Interpretation take place?</label>
                                <input type="date" id="language1" name="interpretationDate"
                                    class="intro-x login__input form-control py-3 px-4 block" required
                                    placeholder="Interpretation Date" value="">
                            </div>
                            <div class="">
                                <label class="mb-3 pb-3" for="">What time did the Interpretation start?</label>
                                <input type="time" id="language1" name="start_time_decided"
                                    class="intro-x login__input form-control py-3 px-4 block" required
                                    placeholder="Start Time" value="">
                            </div>
                            <br>
                            <div>
                                <label for="">What time did the Interpretation end?</label>
                                <input type="time" id="language1" name="end_time_decided"
                                    class="intro-x login__input form-control py-3 px-4 block" required
                                    placeholder="End Time" value="">
                            </div>
                            <br>
                            <div>
                                <label for="">How was your experience?</label>
                                <textarea name="feedback" class="form-control" rows="5"
                                    placeholder="How was your experience?"></textarea>
                            </div>
                            <hr class="my-2 py-2">
                            <button type="submit" class="btn btn-primary">
                                Submit Report
                            </button>
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
{{-- prod --}}
<script
    src="https://www.paypal.com/sdk/js?client-id=Aa2jPGWCMLpswVVeE7IuImi64-45_hAD-gmbh7UY5KhmIUA2CAkaScbXWYjoTPNJiAzQWj_ya7wZNC6s&disable-funding=credit&components=buttons">
</script>

{{-- <script
    src="https://www.paypal.com/sdk/js?client-id=AapYCwr7IL6pstdnEZ8a8Ugv_WMX3qBJflHAfrlFwye5D-7oB22i8Nrky2_AwRLLLTayYkhWS21uKygn&disable-funding=credit&components=buttons"> --}}
{{-- </script> --}}
@endsection