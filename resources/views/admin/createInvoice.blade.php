@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 mt-4">
    <!-- BEGIN: Vertical Form -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
               Add Invoice for {{ $order->user->name }}'s Translation Order
            </h2>
            
        </div>
        <div id="vertical-form" class="p-5">
            <form action="{{ route('invoice.store') }}" method="post">
                @csrf
                @method('POST')
            <div class="preview">
                <div>
                    <div class="intro-x mt-4">
                        <input type="hidden" name="user_id" value="{{ $order->user->id }}">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="text" name="description" class="intro-x login__input form-control py-3 px-4 block" placeholder="Enter Translation Description">
                        <input type="text" name="docQuantity" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Enter Number of Pages (or Words) to be Translated">
                        <input type="number" name="amount" step="0.0001" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Enter Amount to be charged (in dollars)">
                        
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-5">Send Invoice to {{ $order->user->name }}</button>
            </div>
        </form>
           
        </div>
    </div>
</div>
@endsection