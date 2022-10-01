@component('mail::message')
# Discrepancies found in Payment Proof

Hello Customer!<br>

It seems like our team have flagged your Payment Proof with discrepancies..<br>

To resolve this issue, kindly re-submit the payment proof.<br>

OR, contact us at: <a href="mailto:webpage@flowtranslate.com">webpage@flowtranslate.com</a>

@component('mail::button', ['url' => route('myorders')])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent