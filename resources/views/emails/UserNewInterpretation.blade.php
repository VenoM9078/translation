@component('mail::message')
# Your Interpretation Request has been submitted!

Hello {{ $user->name }},

Your interpretation request has been submitted successfully. Here are the details of your request:

**Language:** {{ $interpretation->language }}<br>
**Date:** {{ $interpretation->interpretationDate }}<br>
**Start Time:**  {{ \Carbon\Carbon::parse($interpretation->start_time)->format('H:i') }}<br>
**End Time:**  {{ \Carbon\Carbon::parse($interpretation->end_time)->format('H:i') }}<br>
**Session Format:** {{ $interpretation->session_format }}<br>
**Location:** {{ $interpretation->location }}<br>
**Session Topics:** {{ $interpretation->session_topics }}<br>
**Need a Quote?:** {{ $interpretation->wantQuote ? 'Yes' : 'No' }}

We will get back to you shortly.

Thanks,<br>
{{ config('app.name') }}
@endcomponent