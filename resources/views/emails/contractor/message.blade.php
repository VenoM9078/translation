@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
<h2>Hello, {{$contractor->name}}!</h2>
<p>
    Please click the button below to verify your email address.
</p>
<div class="row" style="display: flex; justify-content: center;">
    <div class="col-md-12">
        <a class="btn mx-auto" href="{{ url('contractor/verify', $contractor->verifyContractor->token)}}" style="display: inline-block; padding: 10px 20px; background-color: #aeaeae; color: #ffffff; text-decoration: none;">Verify Email Address</a>
    </div>
</div>
<br>
<p>
    If you did not create an account, no further action is required.
<br>
<b>
    Regards,<br>
    FlowTranslate
</b>
</p>
{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
