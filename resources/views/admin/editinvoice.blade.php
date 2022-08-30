@extends('admin.layout')

@section('content')
<div class="intro-y col-span-12 mt-4">
    <!-- BEGIN: Vertical Form -->
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base mr-auto">
               Edit Invoice
            </h2>
            
        </div>
        <div id="vertical-form" class="p-5">
            <form action="{{ route('invoice.update', $invoice->id) }}" method="post">
                @csrf
                @method('PUT')
            <div class="preview">
                <div>
                    <div class="intro-x mt-4">
                        <input type="hidden" name="user_id" value="{{ $invoice->user_id }}">
                        <input type="hidden" name="order_id" value="{{ $invoice->order_id }}">
                        <input type="text" name="description" class="intro-x login__input form-control py-3 px-4 block" value="{{ $invoice->description }}">
                        <input type="text" name="docQuantity" class="intro-x login__input form-control py-3 px-4 block mt-4" value="{{ $invoice->docQuantity }}">
                        <input type="number" name="amount" class="intro-x login__input form-control py-3 px-4 block mt-4" value="{{ $invoice->amount }}">
                        
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-5">Send Invoice</button>
            </div>
        </form>
           
        </div>
    </div>
</div>
@endsection