@component('mail::message')
# Late Payment Request Approved!

Hello! <br>

We have looked at your request thoroughly and have decided to approve it! <br>

Your order is now being processed!

@component('mail::button', ['url' => route('myorders')])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
