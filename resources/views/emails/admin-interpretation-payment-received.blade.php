@component('mail::message')
# Customer Payment Received

Dear Admin,

We have received a payment from {{ $interpretation->user->name }} ({{ $interpretation->user->email }}) for
Interpretation Worknumber: {{ $interpretation->worknumber }}.

Please ensure the required services are provided in a timely manner.

Best regards,

Flow Translate System
@endcomponent