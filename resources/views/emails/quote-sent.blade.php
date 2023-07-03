@component('mail::message')
# Quote Submitted

Dear {{ $interpretation->user->name }},

We have submitted a quote for your interpretation request.
@if($interpretation->quote_description != null)
<br>
**Quote Message:** {{$interpretation->quote_description}}
<br>
@endif
Please login to your account to review it.

Thanks,
{{ config('app.name') }}
@endcomponent