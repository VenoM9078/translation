@component('mail::message')
# New Interpretation Request

Dear {{ $contractorInterpretation->contractor->name }},

You have a new interpretation request. Please check your dashboard for more details.

Thank you for your prompt attention to this matter.

Best regards,<br>
{{ config('app.name') }}
@endcomponent