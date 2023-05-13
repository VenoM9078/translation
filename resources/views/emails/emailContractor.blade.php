@component('mail::message')
# Hello!

You have been offered a translation job. Please find the details below:
Total Words: <span style="font-weight: bold">{{ $data['total_words'] }}</span><br>
Total Payment: <span style="font-weight: bold">${{ $data['total_payment'] }}</span><br>
Rate: <span style="font-weight: bold">${{ $data['rate'] }}</span><br>

<div class="container">
<div class="row">
<div class="col-md-4">
<a href="{{ route('contractor.accept', ['order' => $data['id']]) }}" style="background: greenyellow;border-radius:10px;padding:5px;color:white" class="btn btn-outline-success w-24 mr-1 self-center">Accept</a>
</div>
<div class="col-md-4"><a href="{{ route('contractor.decline', ['order' => $data['id']]) }}" style="background:red;border-radius:10px;padding:5px;color:white" class="btn btn-outline-danger w-24 mr-1 self-center">Decline</a>
</div>
</div>
</div>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
