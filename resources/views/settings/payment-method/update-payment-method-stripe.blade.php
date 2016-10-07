<spark-update-payment-method-stripe :user="user" :team="team" :billable-type="billableType" inline-template>
    <div class="panel panel-default">
        <!-- Update Payment Method Heading -->
        <div class="panel-heading">
            <div class="pull-left">
                Update Payment Method
            </div>

            <div class="pull-right">
                <span v-if="billable.card_last_four">
                    <i class="fa fa-btn @{{ cardIcon }}"></i>
                    ************@{{ billable.card_last_four }}
                </span>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="panel-body">
            <!-- Card Update Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                Your card has been updated.
            </div>

            <!-- Generic 500 Level Error Message / Stripe Threw Exception -->
            <div class="alert alert-danger" v-if="form.errors.has('form')">
                We had trouble updating your card. It's possible your card provider is preventing
                us from charging the card. Please contact your card provider or customer support.
            </div>

            <form class="form-horizontal" role="form">
                <!-- Billing Address Fields -->
                @if (Spark::collectsBillingAddress())
                    <h2><i class="fa fa-btn fa-map-marker"></i>Billing Address</h2>

                    @include('spark::settings.payment-method.update-payment-method-address')

                    <h2><i class="fa fa-btn fa-credit-card"></i>Credit Card</h2>
                @endif

                <!-- Cardholder's Name -->
                <div class="form-group">
                    <label for="name" class="col-md-4 control-label">Cardholder's Name</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" v-model="cardForm.name">
                    </div>
                </div>

                <!-- Card Number -->
                <div class="form-group" :class="{'has-error': cardForm.errors.has('number')}">
                    <label for="number" class="col-md-4 control-label">Card Number</label>

                    <div class="col-md-6">
                        <input type="text"
                            class="form-control"
                            data-stripe="number"
                            :placeholder="placeholder"
                            v-model="cardForm.number">

                        <span class="help-block" v-show="cardForm.errors.has('number')">
                            @{{ cardForm.errors.get('number') }}
                        </span>
                    </div>
                </div>

                <!-- Security Code -->
                <div class="form-group">
                    <label for="cvc" class="col-md-4 control-label">Security Code</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" data-stripe="cvc" v-model="cardForm.cvc">
                    </div>
                </div>

                <!-- Expiration Information -->
                <div class="form-group">
                    <label class="col-md-4 control-label">Expiration</label>

                    <div class="col-md-6">
                        <div class="row">
                            <!-- Month -->
                            <div class="col-xs-6">
                                <input type="text" class="form-control"
                                    placeholder="MM" maxlength="2" data-stripe="exp-month" v-model="cardForm.month">
                            </div>

                            <!-- Year -->
                            <div class="col-xs-6">
                                <input type="text" class="form-control"
                                    placeholder="YYYY" maxlength="4" data-stripe="exp-year" v-model="cardForm.year">
                            </div>  
                        </div>
                    </div>
                </div>

                <!-- Zip Code -->
                <div class="form-group" v-if=" ! spark.collectsBillingAddress">
                    <label for="zip" class="col-md-4 control-label">ZIP / Postal Code</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control" v-model="form.zip">
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" @click.prevent="update" :disabled="form.busy">
                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i>Updating
                            </span>

                            <span v-else>
                                Update
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-payment-method-stripe>
