@component('mail::message')
# Quote Submitted

Dear {{ $interpretation->user->name }},

We have submitted a quote for your interpretation request. Please find the details below:

**Quote Price:** {{ $interpretation->quote_price }}

**Quote Description:** {!! nl2br(e($interpretation->quote_description)) !!}

Please login to your account to review and accept the quote.

Thanks,
{{ config('app.name') }}
@endcomponent