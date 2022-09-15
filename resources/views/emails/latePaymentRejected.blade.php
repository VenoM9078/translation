@component('mail::message')
# Late Payment Request Rejected

Hello! <br>

Your late payment request has not been approved.<br>

You may contact us to know why or you may visit the Invoice again.

@component('mail::button', ['url' => route('myorders')])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
