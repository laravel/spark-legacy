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

        <div class="panel-body table-responsive">
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

            <table class="table table-borderless m-b-none">
                <thead></thead>
                <tbody>
                    <tr v-for="plan in paidPlansForActiveInterval">
                        <!-- Plan Name -->
                        <td>
                            <div class="btn-table-align" @click="showPlanDetails(plan)">
                                <span style="cursor: pointer;">
                                    <strong>@{{ plan.name }}</strong>
                                </span>
                            </div>
                        </td>

                        <!-- Plan Features Button -->
                        <td>
                            <button class="btn btn-default m-l-sm" @click="showPlanDetails(plan)">
                                <i class="fa fa-btn fa-star-o"></i>Plan Features
                            </button>
                        </td>

                        <!-- Plan Price -->
                        <td>
                            <div class="btn-table-align">
                                @{{ priceWithTax(plan) | currency }} / @{{ plan.interval | capitalize }}
                            </div>
                        </td>

                        <!-- Plan Select Button -->
                        <td class="text-right">
                            <button class="btn btn-plan"
                                    v-bind:class="{'btn-warning-outline': ! isActivePlan(plan), 'btn-warning': isActivePlan(plan)}"
                                    @click="updateSubscription(plan)"
                                    :disabled="selectingPlan">

                                <span v-if="selectingPlan === plan">
                                    <i class="fa fa-btn fa-spinner fa-spin"></i>Resuming
                                </span>

                                <span v-if="! isActivePlan(plan) && selectingPlan !== plan">
                                    Switch
                                </span>

                                <span v-if="isActivePlan(plan) && selectingPlan !== plan">
                                    Resume
                                </span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</spark-resume-subscription>
