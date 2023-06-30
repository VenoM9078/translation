@component('mail::message')

Dear {{ $interpretation->user->name }},

We are pleased to inform you that your requested task with work number {{ $interpretation->worknumber }} has been
completed.

The interpretation was performed by {{ $interpretation->interpreter->name }} at {{ $interpretation->interpretationDate
}} from {{ \App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->start_time) }} to {{  \App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->end_time) }}.

Thank you for using our service.

Best regards,


@endcomponent