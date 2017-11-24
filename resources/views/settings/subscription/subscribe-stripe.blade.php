<spark-subscribe-stripe :user="user" :team="team"
                :plans="plans" :billable-type="billableType" inline-template>

    <div>
        <!-- Common Subscribe Form Contents -->
        @include('spark::settings.subscription.subscribe-common')

        <!-- Billing Information -->
        <div class="card card-default" v-show="selectedPlan">
            <div class="card-header">{{__('Billing Information')}}</div>

            <div class="card-body">
                <!-- Generic 500 Level Error Message / Stripe Threw Exception -->
                <div class="alert alert-danger" v-if="form.errors.has('form')">
                    {{__('We had trouble validating your card. It\'s possible your card provider is preventing us from charging the card. Please contact your card provider or customer support.')}}
                </div>

                <form role="form">
                    <!-- Billing Address Fields -->
                    @if (Spark::collectsBillingAddress())
                        @include('spark::settings.subscription.subscribe-address')
                    @endif

                    <!-- Cardholder's Name -->
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{__('Cardholder\'s Name')}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" v-model="cardForm.name">
                        </div>
                    </div>

                    <!-- Card Number -->
                    <div class="form-group row">
                        <label for="number" class="col-md-4 col-form-label text-md-right">{{__('Card Number')}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="number" data-stripe="number" v-model="cardForm.number" :class="{'is-invalid': cardForm.errors.has('number')}">

                        <span class="invalid-feedback" v-show="cardForm.errors.has('number')">
                            @{{ cardForm.errors.get('number') }}
                        </span>
                        </div>
                    </div>

                    <!-- Security Code -->
                    <div class="form-group row">
                        <label for="number" class="col-md-4 col-form-label text-md-right">{{__('Security Code')}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cvc" data-stripe="cvc" v-model="cardForm.cvc">
                        </div>
                    </div>

                    <!-- Expiration -->
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{__('Expiration')}}</label>

                        <div class="col-md-6">
                            <div class="row">
                                <!-- Month -->
                                <div class="col">
                                    <input type="text" class="form-control" name="month"
                                           placeholder="MM" maxlength="2" data-stripe="exp-month" v-model="cardForm.month">
                                </div>

                                <!-- Year -->
                                <div class="col">
                                    <input type="text" class="form-control" name="year"
                                           placeholder="YYYY" maxlength="4" data-stripe="exp-year" v-model="cardForm.year">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ZIP Code -->
                    <div class="form-group row" v-if=" ! spark.collectsBillingAddress">
                        <label for="number" class="col-md-4 col-form-label text-md-right">{{__('ZIP / Postal Code')}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="zip" v-model="form.zip">
                        </div>
                    </div>

                    <!-- Coupon -->
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">{{__('Coupon')}}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" v-model="form.coupon" :class="{'is-invalid': form.errors.has('coupon')}">

                        <span class="invalid-feedback" v-show="form.errors.has('coupon')">
                            @{{ form.errors.get('coupon') }}
                        </span>
                        </div>
                    </div>

                    <!-- Tax / Price Information -->
                    <div class="form-group row" v-if="spark.collectsEuropeanVat && countryCollectsVat && selectedPlan">
                        <label class="col-md-4 col-form-label text-md-right">&nbsp;</label>

                        <div class="col-md-6">
                            <div class="alert alert-info" style="margin: 0;">
                                <strong>{{__('Tax')}}:</strong> @{{ taxAmount(selectedPlan) | currency }}
                                <br><br>
                                <strong>{{__('Total Price Including Tax')}}:</strong>
                                @{{ priceWithTax(selectedPlan) | currency }} / @{{ selectedPlan.interval | capitalize }}
                            </div>
                        </div>
                    </div>

                    <!-- Subscribe Button -->
                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary" @click.prevent="subscribe" :disabled="form.busy">
                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Subscribing')}}
                            </span>

                            <span v-else>
                                {{__('Subscribe')}}
                            </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</spark-subscribe-stripe>
