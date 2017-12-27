<spark-update-payment-method-stripe :user="user" :team="team" :billable-type="billableType" inline-template>
    <div class="card card-default">
        <!-- Update Payment Method Heading -->
        <div class="card-header">
            <div class="pull-left">
                {{__('Update Payment Method')}}
            </div>

            <div class="pull-right">
                <span v-if="billable.card_last_four">
                    <i :class="['fa', 'fa-btn', cardIcon]"></i>
                    ************@{{ billable.card_last_four }}
                </span>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="card-body">
            <!-- Card Update Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                {{__('Your card has been updated.')}}
            </div>

            <!-- Generic 500 Level Error Message / Stripe Threw Exception -->
            <div class="alert alert-danger" v-if="form.errors.has('form')">
                {{__('We had trouble updating your card. It\'s possible your card provider is preventing us from charging the card. Please contact your card provider or customer support.')}}
            </div>

            <form role="form">
                <!-- Billing Address Fields -->
                @if (Spark::collectsBillingAddress())
                    @include('spark::settings.payment-method.update-payment-method-address')
                @endif

                <!-- Cardholder's Name -->
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{__('Cardholder\'s Name')}}</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" v-model="cardForm.name">
                    </div>
                </div>

                <!-- Card Details -->
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{__('Card')}}</label>

                    <div class="col-md-6">
                        <div id="card-element"></div>
                        <span class="invalid-feedback" v-show="cardForm.errors.has('card')">
                            @{{ cardForm.errors.get('card') }}
                        </span>
                    </div>
                </div>

                <!-- Zip Code -->
                <div class="form-group row" v-if=" ! spark.collectsBillingAddress">
                    <label for="zip" class="col-md-4 col-form-label text-md-right">{{__('ZIP / Postal Code')}}</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" v-model="form.zip">
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary" @click.prevent="update" :disabled="form.busy">
                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Updating')}}
                            </span>

                            <span v-else>
                                {{__('Update')}}
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-payment-method-stripe>
