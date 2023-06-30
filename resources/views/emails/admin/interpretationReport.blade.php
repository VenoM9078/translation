@component('mail::message')

Dear Admin,

We are pleased to inform you that the task with work number {{ $interpretation->worknumber }} requested by {{
$interpretation->user->name }} has been completed.

The interpretation was performed by {{ $interpretation->interpreter->name }} at {{ $interpretation->interpretationDate
}} from {{  \App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->start_time) }} to {{ \App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->end_time) }}.

Best regards,<br>
{{$interpretation->interpreter->name}}

@endcomponent