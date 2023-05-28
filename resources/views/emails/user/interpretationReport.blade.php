@component('mail::message')

Dear {{ $interpretation->user->name }},

We are pleased to inform you that your requested task with work number {{ $interpretation->worknumber }} has been
completed.

The interpretation was performed by {{ $interpretation->interpreter->name }} at {{ $interpretation->interpretationDate
}} from {{ App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->start_time, request()->ip()) }} to {{  App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->end_time, request()->ip()) }}.

Thank you for using our service.

Best regards,


@endcomponent