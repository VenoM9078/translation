@component('mail::message')
# Hello!

You have been offered a translation job. Please find the details below:
Total Words: <span style="font-weight: bold">{{ $data['total_words'] }}</span><br>
Total Payment: <span style="font-weight: bold">${{ $data['total_payment'] }}</span><br>
Rate: <span style="font-weight: bold">${{ $data['rate'] }}</span><br>

<table style="width: 100%; border: none;">
    <tr>
        <td style="text-align: center; padding: 4px; border: none;">
            <a href="{{ route('contractor.accept', ['order' => $data['id']]) }}"
                style="background: greenyellow; border-radius:10px; padding:10px; color:white; text-decoration: none;">Accept</a>
        </td>
        <td style="text-align: center; padding: 4px; border: none;">
            <a href="{{ route('contractor.decline', ['order' => $data['id']]) }}"
                style="background:red; border-radius:10px; padding:10px; color:white; text-decoration: none;">Decline</a>
        </td>
    </tr>
</table>

Thanks,<br>
{{ config('app.name') }}
@endcomponent