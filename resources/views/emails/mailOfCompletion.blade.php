@component('mail::message')
# Your Translation Order is Completed! 🙌

Hello, {{ $order->user->name }}! <br>

We'd like to inform you that your Translation Order with worknumber <span style="font-weight: bold">{{ $order->worknumber }}</span><br>
has been completed! <br>

You may find the translated files attached with this email. 🔽<br>

We hope you are satisfied with our service! <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
