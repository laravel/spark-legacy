@extends('spark::layouts.app')

@section('scripts')
    <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
@endsection

@section('content')
<spark-register-braintree inline-template>
    <div>
        <div class="spark-screen container">
            <!-- Common Register Form Contents -->
            @include('spark::auth.register-common')

            <!-- Billing Information -->
            <div class="row" v-show="selectedPlan && selectedPlan.price > 0">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-btn fa-credit-card"></i>{{ __('spark::app.billing.billing') }}</div>

                        <div class="panel-body">
                            <!-- Generic 500 Level Error Message / Stripe Threw Exception -->
                            <div class="alert alert-danger" v-if="registerForm.errors.has('form')">
                                {{ __('spark::app.billing.trouble-validating-card') }}
                            </div>

                            <form class="form-horizontal" role="form">
                                <!-- Braintree Container -->
                                <div id="braintree-container" class="m-b-sm"></div>

                                <!-- Coupon Code -->
                                <div class="form-group" :class="{'has-error': registerForm.errors.has('coupon')}" v-if="query.coupon">
                                    <label for="number" class="col-md-4 control-label">{{ __('spark::app.billing.coupon') }}</label>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="coupon" v-model="registerForm.coupon">

                                        <span class="help-block" v-show="registerForm.errors.has('coupon')">
                                            @{{ registerForm.errors.get('coupon') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Terms And Conditions -->
                                <div class="form-group" :class="{'has-error': registerForm.errors.has('terms')}">
                                    <div class="col-sm-6 col-sm-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" v-model="registerForm.terms"> 
                                                {{ __('spark::app.billing.accept-the-terms, ['terms' => '<a href="/terms" target="_blank">'.__('spark::app.billing.terms-of-service').'</a>']) }}

                                                <span class="help-block" v-show="registerForm.errors.has('terms')">
                                                    <strong>@{{ registerForm.errors.get('terms') }}</strong>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Register Button -->
                                <div class="form-group">
                                    <div class="col-sm-6 col-sm-offset-4">
                                        <button type="submit" class="btn btn-primary" :disabled="registerForm.busy">
                                            <span v-if="registerForm.busy">
                                                <i class="fa fa-btn fa-spinner fa-spin"></i>{{ __('spark::app.auth.registering') }}
                                            </span>

                                            <span v-else>
                                                <i class="fa fa-btn fa-check-circle"></i>{{ __('spark::app.auth.register') }}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Features Modal -->
        @include('spark::modals.plan-details')
    </div>
</spark-register-braintree>
@endsection
