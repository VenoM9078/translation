@component('mail::message')
# Your payment has been approved!

Hello Customer!<br>

We hereby inform you that our team has approved your payment and your Translation Order is well under way!<br>

To track its progress - visit your Dashboard.<br>

@component('mail::button', ['url' => route('myorders')])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
