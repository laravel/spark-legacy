<spark-resume-subscription :user="user" :team="team"
                :plans="plans" :billable-type="billableType" inline-template>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left" :class="{'btn-table-align': hasMonthlyAndYearlyPlans}">
                Resume Subscription
            </div>

            <!-- Interval Selector Button Group -->
            <div class="pull-right">
                <div class="btn-group" v-if="hasMonthlyAndYearlyPlans">
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

        <div class="panel-body">
            <!-- Plan Error Message - In General Will Never Be Shown -->
            <div class="alert alert-danger" v-if="planForm.errors.has('plan')">
                @{{ planForm.errors.get('plan') }}
            </div>

            <!-- Cancellation Information -->
            <div class="p-b-lg">
                You have cancelled your subscription to the
                <strong>@{{ activePlan.name }} (@{{ activePlan.interval | capitalize }})</strong> plan.
            </div>

            <div class="p-b-lg">
                The benefits of your subscription will continue until your current billing period ends on
                <strong>@{{ activeSubscription.ends_at | date }}</strong>. You may resume your subscription at no
                extra cost until the end of the billing period.
            </div>

            <!-- European VAT Notice -->
            @if (Spark::collectsEuropeanVat())
                <p class="p-b-lg">
                    All subscription plan prices include applicable VAT.
                </p>
            @endif

            <div class="row">
                <div v-for="plan in plansForActiveInterval">

                    <div class="col-xs-10 col-sm-6 col-xs-offset-1 col-sm-offset-0 ">

                        <div class="panel" :class="{'panel-default' : ! isActivePlan(plan), 'panel-success' : isActivePlan(plan)}">
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


                            <button class="panel-footer" @click="updateSubscription(plan)" :disabled="selectingPlan">

                                <span v-if="selectingPlan === plan">
                                    <i class="fa fa-btn fa-spinner fa-spin"></i>Resuming
                                </span>

                                <span v-if="selectingPlan !== plan && isActivePlan(plan)">
                                    Resume
                                </span>

                                <span v-if="selectingPlan !== plan && !isActivePlan(plan)">
                                    Change and resume
                                </span>
                            </button>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</spark-resume-subscription>
