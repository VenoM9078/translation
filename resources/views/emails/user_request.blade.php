@component('mail::message')
# New User Request

Dear {{$institute->name}} Manager,

There is a new request to join your institute.

User details:
- Name: {{$user->name}}
- Email: {{$user->email}}

Please review this request at your earliest convenience.

Thank you,

{{ config('app.name') }} Team
@endcomponent