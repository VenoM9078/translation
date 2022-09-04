@component('mail::message')
# Hello {{ $user->name }}

You have received a Payment Invoice for the "{{ $order->language1 }} to {{ $order->language2 }}" translation order. <br>

The worknumber of your order is <span style="font-weight: bold;">{{ $order->worknumber }}</span> and amount to be paid is <span style="font-weight: bold;">{{ $invoice->amount }} USD</span>.

Kindly proceed to your User Dashboard (or click the button below) to view invoice & pay the translation fee.

@component('mail::button', ['url' => route('myorders')])
View Pending Orders
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
