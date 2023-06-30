@extends('admin.layout')

@section('content')
<div class="col-span-12 mt-8">
    <div class="intro-y flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">
            Submit Quote
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
                    <form action="{{ route('admin.submitQuote') }}" accept-charset="utf-8" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="intro-x mt-4">
                            <input type="hidden" name="interpretation_id" value="{{ $interpretation->id }}">
                            <div>
                                <label for="">Enter a Quote</label>
                                <input type="number" name="quote_price" step="0.0001"
                                    class="intro-x login__input form-control py-3 px-4 block" required
                                    placeholder="Enter a Quote in Dollars i.e 150">
                            </div>
                            <div class="mt-5">
                                <label for="">Enter Quote Description</label>
                                <textarea name="quote_description"
                                    class="intro-x login__input form-control py-3 px-4 block mt-4 h-30" required
                                    placeholder="Enter Quote Description i.e mention what's included for the customer in this price."></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-5">Send Quote</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection