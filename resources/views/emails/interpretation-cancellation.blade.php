@component('mail::message')
# Interpretation Cancelled

Dear Admin,

The contractor has cancelled an interpretation with worknumber: {{ $interpretation->worknumber
}}.

Kindly find a new interpreter for the aforementioned interpretation.

Thank you,

{{ config('app.name') }}
@endcomponent