@component('mail::message')
# Your Interpretation Request has been submitted!

Hello {{ $user->name }},

Your interpretation request has been submitted successfully. Here are the details of your request:

**Language:** {{ $interpretation->language }}<br>
**Date:** {{ $interpretation->interpretationDate }}<br>
**Start Time:** {{ $interpretation->start_time }}<br>
**End Time:** {{ $interpretation->end_time }}<br>
**Session Format:** {{ $interpretation->session_format }}<br>
**Location:** {{ $interpretation->location }}<br>
**Session Topics:** {{ $interpretation->session_topics }}<br>
**Need a Quote?:** {{ $interpretation->wantQuote ? 'Yes' : 'No' }}

We will get back to you shortly.

Thanks,<br>
{{ config('app.name') }}
@endcomponent