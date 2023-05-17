@component('mail::message')

Dear Admin,

We are pleased to inform you that the task with work number {{ $interpretation->worknumber }} requested by {{
$interpretation->user->name }} has been completed.

The interpretation was performed by {{ $interpretation->interpreter->name }} at {{ $interpretation->interpretationDate
}} from {{ $interpretation->start_time }} to {{ $interpretation->end_time }}.

Best regards,<br>
{{$interpretation->interpreter->name}}

@endcomponent