@component('mail::message')
# Payment Received

Dear {{ $interpretation->user->name }},

We have received your payment for Interpretation Worknumber: {{ $interpretation->worknumber }}.

Thank you for choosing our services. Keep checking your Dashboard to track the progress of your Interpretation!

Best regards,

Flow Translate Team
@endcomponent