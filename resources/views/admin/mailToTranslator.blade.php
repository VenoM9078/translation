@extends('admin.layout')

@section('content')

<div class="alert alert-primary show flex items-center mb-4" role="alert"> <i data-lucide="alert-circle" class="w-6 h-6 mr-2"></i> Documents to be translated are automatically attached to this email! </div>

<div class="intro-y box">

    <div id="vertical-form" class="p-5">
        <div class="preview">
            <div>
              <form action="{{ route('sendDocumentsToTranslator') }}" accept-charset="utf-8" method="post">
                @csrf
                @method('POST')
                <div class="intro-x mt-4">
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="email" name="translator_email" class="intro-x login__input form-control py-3 px-4 block" required placeholder="Enter Translator's Email">
                    <input type="text" name="email_title" class="intro-x login__input form-control py-3 px-4 block mt-4" required placeholder="Email Title">
                    <input type="text" name="email_body" class="intro-x login__input form-control py-3 px-4 block mt-4" required placeholder="Message...">
                                                
                </div>
              
              <button type="submit" name="submit" class="btn btn-primary mt-5">Send Email</button>
            </form>
            </div>
        </div>
       
    </div>
</div>



@endsection