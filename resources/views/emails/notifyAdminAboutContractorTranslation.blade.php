@component('mail::message')
# Hello,

We'd like to inform you that the contractor you assigned for your translation order with name
<span style="font-weight: bold">{{ $contractorName }}</span> has submitted the translation file. <br>
You may find the details of your order below. <br>

@component('mail::panel')
<div class="text-center">
<h1>Order Details</h1>
</div>
<div class="text-center">
<p>Order Number: <span style="font-weight: bold">{{ $order->worknumber }}</span></p>
<p>Total Words: <span style="font-weight: bold">{{ $contractorOrder->total_words }}</span></p>
<p>Order By: <span style="font-weight: bold">{{ $order->user->name }}</span></p>
<p>Total Payment: <span style="font-weight: bold">${{ $contractorOrder->total_payment }}</span></p>
</div>
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
