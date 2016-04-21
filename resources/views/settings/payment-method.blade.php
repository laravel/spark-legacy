@if (Spark::billsUsingStripe())
    @include('spark::settings.payment-method-stripe')
@else
    @include('spark::settings.payment-method-braintree')
@endif
