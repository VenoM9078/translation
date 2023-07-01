@component('mail::message')
# Hello, {{ $user->name }}!

Your translation order has been placed!
An invoice will be sent to you shortly!<br>

Your assigned worknumber is <bold><span style="color: #000;">{{ $order->worknumber }}</span></bold>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
