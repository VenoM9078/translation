@component('mail::message')

Dear Admin,

We are pleased to inform you that the task with work number {{ $interpretation->worknumber }} requested by {{
$interpretation->user->name }} has been completed.

The interpretation was performed by {{ $interpretation->interpreter->name }} at {{ $interpretation->interpretationDate
}} from {{  App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->start_time, request()->ip()) }} to {{ App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->end_time,request()->ip()) }}.

Best regards,<br>
{{$interpretation->interpreter->name}}

@endcomponent