@component('mail::message')
# Contractor Action

Contractor {{ $contractor->name }} has {{ $action }} an interpretation request.

**Interpretation Details:**
- Worknumber: {{ $interpretation->worknumber }}
- Description: {{ $interpretation->description }}
- Language: {{ $interpretation->language }}
- Interpretation Date: {{ $interpretation->interpretationDate }}
- Start Time: {{  App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->start_time, request()->ip()) }}
- End Time: {{ App\Helpers\HelperClass::convertTimeToCurrentTimeZone($interpretation->end_time, request()->ip()) }}
- Session Format: {{ $interpretation->session_format }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent