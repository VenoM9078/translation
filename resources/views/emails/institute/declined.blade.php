@component('mail::message')
# Institute Request Declined

Dear {{ $user->name }},

We regret to inform you that your request to set up the institute named **{{ $institute->name }}** has been declined.

If you have any questions or if you believe this is a mistake, please contact our team or try again.

Best Regards,

{{ config('app.name') }}
@endcomponent