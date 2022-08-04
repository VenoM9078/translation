@component('mail::message')
# A new Translation Order has been placed!

A new translation order with work number <span style="font-weight: bold">{{ $order->worknumber }}</span> has been placed
 by <span style="font-weight: bold">{{ $user->name }}</span> ({{ $user->email }}). <br>

 Respond to it ASAP.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
