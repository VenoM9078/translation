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
                            <div class="intro-x mt-4">
                                <label for="">Start Time</label>
                                <input type="time" id="language1" name="start_time_decided"
                                    class="intro-x login__input form-control py-3 px-4 block" required
                                    placeholder="Start Time" value="">
                                <br>
                                <label for="">End Time</label>
                                <input type="time" id="language1" name="end_time_decided"
                                    class="intro-x login__input form-control py-3 px-4 block" required
                                    placeholder="End Time" value="">
                                <input type="number" name="contractor_interpretation_id" value="{{ $interpretation->id }}" hidden>
                                <br>
                                <label for="">Feedback</label>
                                <textarea name="feedback" class="form-control" rows="10" placeholder="Type feedback"></textarea>
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
    <script
        src="https://www.paypal.com/sdk/js?client-id=AapYCwr7IL6pstdnEZ8a8Ugv_WMX3qBJflHAfrlFwye5D-7oB22i8Nrky2_AwRLLLTayYkhWS21uKygn&disable-funding=credit&components=buttons">
    </script>
@endsection
