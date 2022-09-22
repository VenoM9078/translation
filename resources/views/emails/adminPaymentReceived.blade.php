@component('mail::message')
# Payment Received for Order Worknumber: {{ $order->worknumber }}

{{ $order->user->name }} has sent a payment of {{ $order->amount }} USD for their order <span style="font-weight: bold">{{ $order->worknumber }}</span>.

Next step? Forward their documents to the appropriate party.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
