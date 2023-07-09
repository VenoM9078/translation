@component('mail::message')

Dear {{ $interpretation->interpreter->name }},

This is a reminder for your upcoming interpretation task.

Here are the details:

Work Number: {{ $interpretation->worknumber }} <br>
Requested by: {{ $interpretation->user->name }} <br>
Date: {{ $interpretation->interpretationDate }} <br>
Start time: {{ $interpretation->start_time }} <br>
End time: {{ $interpretation->end_time }} <br>

Please make sure to prepare for the session.

Best regards,<br>
Flow Translate

@endcomponent