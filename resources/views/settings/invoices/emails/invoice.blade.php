@if ($billable instanceof Laravel\Spark\Team)
    {{__('Hi :name', ['name' => $billable->name])}}
@else
    {{__('Hi :name', ['name' => explode(' ', $billable->name)[0]])}}
@endif

<br><br>

{{__('Thanks for your continued support. We\'ve attached a copy of your invoice for your records. Please let us know if you have any questions or concerns!')}}

<br><br>

{{__('Thanks!')}}

<br>

{{ $invoiceData['product'] }}

