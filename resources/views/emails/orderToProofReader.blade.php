@component('mail::message')
# Hello!

Order Worknumber: <span style="font-weight: bold">{{ $order->worknumber }}</span> <br>
Current Language: <span style="font-weight: bold">{{ $order->language1 }}</span><br>
Translated Documents: <span style="font-weight: bold">{{ $order->language2 }}</span><br>
Total Payment: <span style="font-weight: bold">{{ $proofRead->total_payment }}</span><br>
Rate: <span style="font-weight: bold">{{ $proofRead->rate }}</span><br>
Translated Documents: <span style="font-weight: bold">{{ $order->language2 }}</span><br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
