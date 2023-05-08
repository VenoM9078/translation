@component('mail::message')
# Hello!

You have been offered a translation job. Please find the details below:
Order Description: <span style="font-weight: bold">{{ $data['description'] }}</span> <br>
Order Amount: <span style="font-weight: bold">{{ $data['amount'] }}</span><br>
<div class="container">
    <div class="row">
        <div class="col-md-4">Accept</div>
        <div class="col-md-4">Decline</div>
    </div>
</div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
