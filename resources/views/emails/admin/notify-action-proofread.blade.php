@component('mail::message')
# Contractor Action

Contractor {{ $contractor->name }} has {{ $action }} the Proof Read request.

**Proof Read Details:**
- Worknumber: {{ $proofRead->order->worknumber }}
- Language #1: {{ $proofRead->order->language1 }}
- Language #2: {{ $proofRead->order->language2 }}
- Proof Read Received: {{ $proofRead->created_at->format('m-d-Y h:m:s') }}
- Proof Read Rate: {{ $proofRead->rate }}
- Proof Read Total Payment: {{ $proofRead->total_payment }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent