@component('mail::message')
# Hello, {{ $order->user->name }}!

We have received your payment of <span style="font-weight: bold;">{{ $order->amount }} USD</span>. <br>

We'd like to inform you that your Translation order is now being processed. <br>

To track its progress - frequently visit your dashboard!

@component('mail::button', ['url' => route('myorders')])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
