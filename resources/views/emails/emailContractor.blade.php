@component('mail::message')
# Hello!

You have been offered a translation job. Please find the details below:
Order Description: <span style="font-weight: bold">{{ $data['description'] }}</span> <br>
Order Amount: <span style="font-weight: bold">{{ $data['amount'] }}</span><br>
<div class="container">
<div class="row">
<div class="col-md-4">
<a href="{{ route('contractor.accept', ['order' => $data['id']]) }}" class="btn btn-outline-success w-24 mr-1 self-center">Accept</a>
</div>
<div class="col-md-4"><a href="{{ route('contractor.decline', ['order' => $data['id']]) }}" class="btn btn-outline-danger w-24 mr-1 self-center">Decline</a>
</div>
</div>
</div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
