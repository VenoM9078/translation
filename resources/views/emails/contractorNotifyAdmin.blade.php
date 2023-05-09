@component('mail::message')
# Hello,

@if ($isAccepted == false)
We'd like to inform you that the contractor you assigned for your translation order with name
<span style="font-weight: bold">{{ $contractorName }}</span> has declined the offer. <br>
You may find the details of your order below. <br>
@elseif ($isAccepted == true)
We'd like to inform you that the contractor you assigned for your translation order with name
<span style="font-weight: bold">{{ $contractorName }}</span> has accepted the offer. <br>
You may find the details of your order below. <br>
@endif
@component('mail::panel')
<div class="text-center">
<h3>Order Details</h3>
</div>
<div class="text-center">
<p>Order Number: <span style="font-weight: bold">{{ $contractorOrder->id }}</span></p>
<p>Description: <span style="font-weight: bold">{{ $contractorOrder->description }}</span></p>
<p>Amount: <span style="font-weight: bold">${{ $contractorOrder->amount }}</span></p>
</div>
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
