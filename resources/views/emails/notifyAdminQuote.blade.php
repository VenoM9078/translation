@component('mail::message')
# Hello!

User named <b>{{$data['name']}}</b> has <b>{{$statusMessage}}</b> the quote for Order <bold><span style="color: #000;">{{ $data['worknumber'] }}</span></bold>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
