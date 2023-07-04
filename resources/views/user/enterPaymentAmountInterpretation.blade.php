@extends('user.layout')

@section('content')

<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">
            Enter Payment Amount
        </h2>
    </div>

    @if ($message = Session::get('message'))
    <div class="alert alert-success mt-3 mb-3">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="intro-y box">
        <div id="vertical-form" class="p-5">
            <div class="preview">
                <div>
                    <form action="{{ route('user.proceedToPayNowInterpretation') }}" accept-charset="utf-8"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="intro-x mt-4">

                            <input type="hidden" name="interpretation_id" value="{{$interpretation->id}}">

                            <div class="w-full">
                                <label>Payment (in Dollars)</label>
                                <input type="number" name="amount" step="0.00001" placeholder="Enter Amount"
                                    class="intro-x w-full login__input form-control py-3 px-4 block mt-2" required
                                    value="">
                            </div>
                        </div>

                        <div class="btn-group mt-5" role="group" aria-label="Basic example">

                            <button type="submit" id="uploadBtn" class="btn btn-primary">Proceed</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection