@if (Spark::billsUsingStripe())
    @include('spark::settings.subscription.subscribe-stripe')
@else
    @include('spark::settings.subscription.subscribe-braintree')
@endif
