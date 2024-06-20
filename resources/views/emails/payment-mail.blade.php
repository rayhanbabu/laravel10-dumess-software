<x-mail::message>

{{$details['subject']}}


<x-mail::table>
| Description         | Amount   |
| -------------       | --------:|
| Payable Amount      | {{$details['payment']}}             |
| Payment Status      | {{$details['payment_status']}}      |
| Payment Type        | {{$details['paymenttype']}}         |
| Payment Method      | {{$details['payment_method']}}      |
| Payment Time        | {{$details['paymenttime']}}         |
</x-mail::table>


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
