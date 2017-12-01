<spark-subscribe-braintree :user="user" :team="team"
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

                <form role="form" ref="form">
                    <!-- Payment Method -->
                    <div class="form-group row" v-if="hasPaymentMethod()">
                        <label for="use_exiting_payment_method" class="col-md-4 col-form-label text-md-right">{{__('Payment Method')}}</label>

                        <div class="col-md-6">
                            <select name="use_exiting_payment_method" v-model="form.use_exiting_payment_method" id="use_exiting_payment_method" class="form-control">
                                <option value="1">{{__('Use existing payment method')}}</option>
                                <option value="0">{{__('Use a different method')}}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Braintree Container -->
                    <div class="form-group row"  v-show="form.use_exiting_payment_method != '1'">
                        <div class="col-md-6 offset-md-4">
                            <div id="braintree-subscribe-container" class="m-b-md"></div>
                        </div>
                    </div>

                    <!-- Subscribe Button -->
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button v-if="form.use_exiting_payment_method == 1" type="submit" class="btn btn-primary" @click.prevent="subscribe" :disabled="form.busy">
                                <span v-if="form.busy">
                                    <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Subscribing')}}
                                </span>

                                <span v-else>
                                    {{__('Subscribe')}}
                                </span>
                            </button>
                            <button v-else type="submit" class="btn btn-primary" :disabled="form.busy">
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
</spark-subscribe-braintree>
