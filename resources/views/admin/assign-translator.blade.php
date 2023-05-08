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
                                <textarea type="text" name="description" required class="intro-x login__input form-control py-3 px-4 block"
                                    placeholder="Enter Translation Description" value=""></textarea>
                                <input type="number" required name="amount"
                                    class="intro-x login__input form-control py-3 px-4 block mt-4"
                                    placeholder="Enter Amount to be charged (in dollars)" value="">
                                <select name="contractor_id" required
                                    class="intro-x login__input form-control py-3 px-4 block mt-4">
                                    <option value="-1" selected disabled>Select Contractor</option>
                                    @foreach ($contractors as $contractor)
                                        <option value="{{ $contractor->id }}">{{ $contractor->name }}
                                            ({{ $contractor->email }})
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
