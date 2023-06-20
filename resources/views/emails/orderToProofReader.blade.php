@component('mail::message')
# Hello!

Order Worknumber: <span style="font-weight: bold">{{ $order->worknumber }}</span> <br>
Current Language: <span style="font-weight: bold">{{ $order->language1 }}</span><br>
Translated Documents: <span style="font-weight: bold">{{ $order->language2 }}</span><br>
Total Payment: <span style="font-weight: bold">{{ $proofRead->total_payment }}</span><br>
Rate: <span style="font-weight: bold">{{ $proofRead->rate }}</span><br>
Translated Documents: <span style="font-weight: bold">{{ $order->language2 }}</span><br>  
Due Date: {{ $proofRead->proof_read_due_date }}  
ProofRead Type: {{ $proofRead->proofread_type ?? '-' }}  
ProofRead Adjust ($): {{ $proofRead->p_adjust }}  
Unit: {{ $proofRead->p_unit }}  
P. Adjust Note: {{ $proofRead->proof_read_adjust_note }}  
Paid: {{ $proofRead->proof_read_paid == 1 ? 'Yes' : 'No' }}  
Message: {{ $proofRead->message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
