@component('mail::message')
# Institute Acceptance Notification

Dear {{ $user->name }},

We are excited to inform you that your request to set up the institute named **{{ $institute->name }}** has been
accepted!

Your institute members can join using the passcode:

## {{ $institute->passcode }}

Thank you for your patience and we look forward to your active participation.

Best Regards,

{{ config('app.name') }}
@endcomponent