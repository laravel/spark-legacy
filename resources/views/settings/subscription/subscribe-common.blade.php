<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-left" :class="{'btn-table-align': hasMonthlyAndYearlyPlans}">
            Subscribe
        </div>

        <!-- Interval Selector Button Group -->
        <div class="pull-right">
            <div class="btn-group" v-if="hasMonthlyAndYearlyPaidPlans">
                <!-- Monthly Plans -->
                <button type="button" class="btn btn-default"
                        @click="showMonthlyPlans"
                        :class="{'active': showingMonthlyPlans}">

                    Monthly
                </button>

                <!-- Yearly Plans -->
                <button type="button" class="btn btn-default"
                        @click="showYearlyPlans"
                        :class="{'active': showingYearlyPlans}">

                    Yearly
                </button>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="panel-body table-responsive">
        <!-- Subscription Notice -->
        <div class="p-b-lg">
            You are not subscribed to a plan. Choose from the plans below to get started.
        </div>

        <!-- European VAT Notice -->
        @if (Spark::collectsEuropeanVat())
            <p class="p-b-lg">
                All subscription plan prices are excluding applicable VAT.
            </p>
        @endif

        <!-- Plan Error Message -->
        <div class="alert alert-danger" v-if="form.errors.has('plan')">
            @{{ form.errors.get('plan') }}
        </div>

        <div class="row">
            <div v-for="plan in paidPlansForActiveInterval">

                <div class="col-xs-10 col-sm-6 col-xs-offset-1 col-sm-offset-0 ">

                    <div class="panel" :class="{'panel-default' : selectedPlan !== plan, 'panel-success' : selectedPlan === plan}">
                        <div class="panel-body">
                            <div class="text-center">
                                <h4 class="text-uppercase">
                                    <strong>@{{ plan.name }}</strong>
                                </h4>
                            </div>

                            <ul>
                                <li v-for="feature in plan.features">
                                    @{{ feature }}
                                </li>
                            </ul>

                            <div class="text-center">
                                <div v-if="plan.trialDays">
                                    @{{ plan.trialDays}} Day Trial
                                </div>

                                <span class="text-muted" v-if="plan.price == 0">
                                    Free
                                </span>

                                <span class="text-muted" v-else>
                                    @{{ priceWithTax(plan) | currency spark.currencySymbol }} / @{{ plan.interval | capitalize }}
                                </span>
                            </div>
                        </div>

                        <button class="panel-footer"
                        @click="selectPlan(plan)">
                            <span v-if="selectedPlan === plan">
                                <i class="fa fa-btn fa-check"></i> Selected
                            </span>
                            <span v-if="selectedPlan !== plan">
                                Select
                            </span>
                        </button>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
