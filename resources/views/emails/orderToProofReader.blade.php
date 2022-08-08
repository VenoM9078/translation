@component('mail::message')
# Hello!

Order Worknumber: <span style="font-weight: bold">{{ $order->worknumber }}</span> <br>
Current Language: <span style="font-weight: bold">{{ $order->language1 }}</span><br>
Language to be translated in: <span style="font-weight: bold">{{ $order->language2 }}</span><br>

Kindly find the documents to be proofread attached below.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
