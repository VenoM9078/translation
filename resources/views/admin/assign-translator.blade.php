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
                                <label for="amount">Enter total words</label>
                                <input type="number" required name="total_words"
                                    class="intro-x login__input form-control px-4 block"
                                    placeholder="Enter Total Words" value="">
                                <br>
                                <label for="amount" class="mt-2">Enter Total Payment</label>
                                <input type="number" required name="total_payment"
                                    class="intro-x login__input form-control px-4 block"
                                    placeholder="Enter Total Payment" value="">
                                <br>
                                <label for="amount" class="mt-2">Enter Rate</label>
                                <input type="number" required name="rate"
                                    class="intro-x login__input form-control px-4 block mt-1"
                                    placeholder="Enter Rate" value="">
                                <br>
                                <div class="mt-1">
                                    <label for="amount" class="mt-2">Select Translators</label>
                                    <select data-placeholder="Select A Contractor" required name="contractor_id"
                                        class="tom-select w-full">
                                        <option value="-1" selected disabled>Select Contractor</option>
                                        @foreach ($contractors as $contractor)
                                            <option value="{{ $contractor->id }}">{{ $contractor->name }}
                                                (${{ $contractor->translation_rate }} / hour)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary mt-5" value="Send Email">
                        </div>
                </form>

            </div>
        </div>
    </div>
@endsection
