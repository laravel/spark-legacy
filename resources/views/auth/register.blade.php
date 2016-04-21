@if (Spark::billsUsingStripe())
    @include('spark::auth.register-stripe')
@else
    @include('spark::auth.register-braintree')
@endif
