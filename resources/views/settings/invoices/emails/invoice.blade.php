@if ($billable instanceof Laravel\Spark\Team)
    Hi {{ $billable->name }}!
@else
    Hi {{ explode(' ', $billable->name)[0] }}!
@endif

<br><br>

Thanks for your continued support. We've attached a copy of your invoice for your records.
Please let us know if you have any questions or concerns!

<br><br>

Thanks!

<br>

{{ $invoiceData['product'] }}

