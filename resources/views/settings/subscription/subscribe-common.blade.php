<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-left" :class="{'btn-table-align': hasMonthlyAndYearlyPlans}">
            @lang('Subscribe')
        </div>

        <!-- Interval Selector Button Group -->
        <div class="pull-right">
            <div class="btn-group" v-if="hasMonthlyAndYearlyPaidPlans">
                <!-- Monthly Plans -->
                <button type="button" class="btn btn-default"
                        @click="showMonthlyPlans"
                        :class="{'active': showingMonthlyPlans}">

                    @lang('Monthly')
                </button>

                <!-- Yearly Plans -->
                <button type="button" class="btn btn-default"
                        @click="showYearlyPlans"
                        :class="{'active': showingYearlyPlans}">

                    @lang('Yearly')
                </button>
            </div>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="panel-body table-responsive">
        <!-- Subscription Notice -->
        <div class="p-b-lg">
            @lang('You are not subscribed to a plan. Choose from the plans below to get started.')
        </div>

        <!-- European VAT Notice -->
        @if (Spark::collectsEuropeanVat())
            <p class="p-b-lg">
                @lang('All subscription plan prices are excluding applicable VAT.')
            </p>
        @endif

        <!-- Plan Error Message -->
        <div class="alert alert-danger" v-if="form.errors.has('plan')">
            @{{ form.errors.get('plan') }}
        </div>

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
                            <i class="fa fa-btn fa-star-o"></i>@lang('Plan Features')
                        </button>
                    </td>

                    <!-- Plan Price -->
                    <td>
                        <div class="btn-table-align">
                            @{{ plan.price | currency }} / @{{ plan.interval | capitalize }}
                        </div>
                    </td>

                    <!-- Trial Days -->
                    <td>
                        <div class="btn-table-align" v-if="plan.trialDays && ! hasSubscribed(plan)">
                            @lang(':days Day Trial', ['days' => '@{{ plan.trialDays}}'])
                        </div>
                    </td>

                    <!-- Plan Select Button -->
                    <td class="text-right">
                        <button class="btn btn-primary-outline btn-plan"
                                v-if="selectedPlan !== plan"
                                @click="selectPlan(plan)"
                                :disabled="form.busy">

                            @lang('Select')
                        </button>

                        <button class="btn btn-primary btn-plan"
                                v-if="selectedPlan === plan"
                                disabled>

                            <i class="fa fa-btn fa-check"></i>@lang('Selected')
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
