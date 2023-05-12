@component('mail::message')
# Hello!

Order Worknumber: <span style="font-weight: bold">{{ $order->worknumber }}</span> <br>
Current Language: <span style="font-weight: bold">{{ $order->language1 }}</span><br>
Translated Documents: <span style="font-weight: bold">{{ $order->language2 }}</span><br>
@if($proofRead->description != '') Description: <span style="font-weight: bold">{{ $proofRead->description }}</span><br> @endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
