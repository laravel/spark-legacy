@extends('spark::layouts.app')

@section('scripts')
    <script src="https://js.stripe.com/v2/"></script>
@endsection

@section('content')
<spark-register-stripe inline-template>
    <div>
        <div class="spark-screen container">
            <!-- Common Register Form Contents -->
            @include('spark::auth.register-common')

            <!-- Billing Information -->
            <div class="row" v-if="selectedPlan && selectedPlan.price > 0">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Billing Information</div>

                        <div class="panel-body">
                            <!-- Generic 500 Level Error Message / Stripe Threw Exception -->
                            <div class="alert alert-danger" v-if="registerForm.errors.has('form')">
                                We had trouble validating your card. It's possible your card provider is preventing
                                us from charging the card. Please contact your card provider or customer support.
                            </div>

                            <form class="form-horizontal" role="form">
                                <!-- Billing Address Fields -->
                                @if (Spark::collectsBillingAddress())
                                    <h2><i class="fa fa-btn fa-map-marker"></i>Billing Address</h2>

                                    @include('spark::auth.register-address')

                                    <h2><i class="fa fa-btn fa-credit-card"></i>Credit Card</h2>
                                @endif

                                <!-- Cardholder's Name -->
                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">Cardholder's Name</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" v-model="cardForm.name">
                                    </div>
                                </div>

                                <!-- Card Number -->
                                <div class="form-group" :class="{'has-error': cardForm.errors.has('number')}">
                                    <label class="col-md-4 control-label">Card Number</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="number" data-stripe="number" v-model="cardForm.number">

                                        <span class="help-block" v-show="cardForm.errors.has('number')">
                                            @{{ cardForm.errors.get('number') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Security Code -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Security Code</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="cvc" data-stripe="cvc" v-model="cardForm.cvc">
                                    </div>
                                </div>

                                <!-- Expiration -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Expiration</label>

                                    <!-- Month -->
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="month"
                                            placeholder="MM" maxlength="2" data-stripe="exp-month" v-model="cardForm.month">
                                    </div>

                                    <!-- Year -->
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="year"
                                            placeholder="YYYY" maxlength="4" data-stripe="exp-year" v-model="cardForm.year">
                                    </div>
                                </div>

                                <!-- ZIP Code -->
                                <div class="form-group" :class="{'has-error': registerForm.errors.has('zip')}" v-if=" ! spark.collectsBillingAddress">
                                    <label class="col-md-4 control-label">ZIP / Postal Code</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="zip" v-model="registerForm.zip">

                                        <span class="help-block" v-show="registerForm.errors.has('zip')">
                                            @{{ registerForm.errors.get('zip') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Coupon Code -->
                                <div class="form-group" :class="{'has-error': registerForm.errors.has('coupon')}" v-if="query.coupon">
                                    <label class="col-md-4 control-label">Coupon Code</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="coupon" v-model="registerForm.coupon">

                                        <span class="help-block" v-show="registerForm.errors.has('coupon')">
                                            @{{ registerForm.errors.get('coupon') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Terms And Conditions -->
                                <div class="form-group" :class="{'has-error': registerForm.errors.has('terms')}">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" v-model="registerForm.terms">
                                                I Accept The <a href="/terms" target="_blank">Terms Of Service</a>

                                                <span class="help-block" v-show="registerForm.errors.has('terms')">
                                                    <strong>@{{ registerForm.errors.get('terms') }}</strong>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tax / Price Information -->
                                <div class="form-group" v-if="spark.collectsEuropeanVat && countryCollectsVat && selectedPlan">
                                    <label class="col-md-4 control-label">&nbsp;</label>

                                    <div class="col-md-6">
                                        <div class="alert alert-info" style="margin: 0;">
                                            <strong>Tax:</strong> @{{ taxAmount(selectedPlan) | currency }}
                                            <br><br>
                                            <strong>Total Price Including Tax:</strong>
                                            @{{ priceWithTax(selectedPlan) | currency }} / @{{ selectedPlan.interval | capitalize }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Register Button -->
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary" @click.prevent="register" :disabled="registerForm.busy">
                                            <span v-if="registerForm.busy">
                                                <i class="fa fa-btn fa-spinner fa-spin"></i>Registering
                                            </span>

                                            <span v-else>
                                                <i class="fa fa-btn fa-check-circle"></i>Register
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
</spark-register-stripe>
@endsection
