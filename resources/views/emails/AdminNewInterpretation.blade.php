@component('mail::message')
# A new Interpretation Request has been submitted!

A new interpretation request has been submitted by **{{ $user->name }}** ({{ $user->email }}).<br>

**Language:** {{ $interpretation->language }}<br>
**Date:** {{ $interpretation->interpretationDate }}<br>
**Start Time:** {{\App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->start_time) }}
<br>
**End Time:** {{ \App\Helpers\HelperClass::onlyShowHoursMinutes($interpretation->end_time) }}<br>
**Session Format:** {{ $interpretation->session_format }}<br>
**Location:** {{ $interpretation->location }}<br>
**Session Topics:** {{ $interpretation->session_topics }}<br>
**Need a Quote?:** {{ $interpretation->wantQuote ? 'Yes' : 'No' }}

Respond to the request ASAP.

Thanks,<br>
{{ config('app.name') }}
@endcomponent