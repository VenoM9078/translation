@component('mail::message')
# Contractor Action

Contractor {{ $contractor->name }} has {{ $action }} an interpretation request.

**Interpretation Details:**
- Worknumber: {{ $interpretation->worknumber }}
- Description: {{ $interpretation->description }}
- Language: {{ $interpretation->language }}
- Interpretation Date: {{ $interpretation->interpretationDate }}
- Start Time: {{ $interpretation->start_time }}
- End Time: {{ $interpretation->end_time }}
- Session Format: {{ $interpretation->session_format }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent