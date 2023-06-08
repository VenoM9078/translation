@component('mail::message')
# Quote Submitted

Dear {{ $order->user->name }},

We have submitted a quote for your translation request. Please find the details below:

**Quote Price:** {{ $order->quote_price }}

**Quote Description:** {!! nl2br(e($order->quote_description)) !!}

Please login to your account to review and accept the quote.

Thanks,
{{ config('app.name') }}
@endcomponent