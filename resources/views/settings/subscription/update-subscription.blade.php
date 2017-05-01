<spark-update-subscription :user="user" :team="team"
                :plans="plans" :billable-type="billableType" inline-template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left" :class="{'btn-table-align': hasMonthlyAndYearlyPlans}">
                    @lang('Update Subscription')
                </div>

                <!-- Interval Selector Button Group -->
                <div class="pull-right">
                    <div class="btn-group" v-if="hasMonthlyAndYearlyPlans">
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
                <!-- Plan Error Message - In General Will Never Be Shown -->
                <div class="alert alert-danger" v-if="planForm.errors.has('plan')">
                    @{{ planForm.errors.get('plan') }}
                </div>

                <!-- Current Subscription (Active) -->
                <div class="p-b-lg" v-if="activePlan.active">
                    @lang('You are currently subscribed to the :plan plan.', ['plan' => '<strong>@{{ activePlan.name }} (@{{ activePlan.interval | capitalize }})</strong>'])
                </div>

                <!-- Current Subscription (Archived) -->
                <div class="alert alert-warning m-b-lg" v-if=" ! activePlan.active">
                    @lang('You are currently subscribed to the :plan plan.', ['plan' => '<strong>@{{ activePlan.name }} (@{{ activePlan.interval | capitalize }})</strong>'])
                    @lang('This plan has been discontinued, but you may continue your subscription to this plan as long as you wish. If you cancel your subscription and later want to begin a new subscription, you will need to choose from one of the active plans listed below.')
                </div>

                <!-- European VAT Notice -->
                @if (Spark::collectsEuropeanVat())
                    <p class="p-b-lg">
                        @lang('All subscription plan prices include applicable VAT.')
                    </p>
                @endif

                <table class="table table-borderless m-b-none">
                    <thead></thead>
                    <tbody>
                        <tr v-for="plan in plansForActiveInterval">
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
                                    <span v-if="plan.price == 0">
                                        @lang('Free')
                                    </span>

                                    <span v-else>
                                        @{{ priceWithTax(plan) | currency }} / @{{ plan.interval | capitalize }}
                                    </span>
                                </div>
                            </td>

                            <!-- Plan Select Button -->
                            <td class="text-right">
                                <button class="btn btn-primary btn-plan" v-if="isActivePlan(plan)" disabled>
                                    <i class="fa fa-btn fa-check"></i>@lang('Current Plan')
                                </button>

                                <button class="btn btn-primary-outline btn-plan"
                                        v-if=" ! isActivePlan(plan) && selectingPlan !== plan"
                                        @click="confirmPlanUpdate(plan)"
                                        :disabled="selectingPlan">

                                    @lang('Switch')
                                </button>

                                <button class="btn btn-primary btn-plan"
                                        v-if="selectingPlan && selectingPlan === plan"
                                        disabled>

                                    <i class="fa fa-btn fa-spinner fa-spin"></i>@lang('Updating')
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Confirm Plan Update Modal -->
        <div class="modal fade" id="modal-confirm-plan-update" tabindex="-2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" v-if="confirmingPlan">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">
                            @lang('Update Subscription')
                        </h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p>
                            @lang('Are you sure you want to switch to the :plan plan?', [
                                'plan' => '<strong>@{{ confirmingPlan.name }} (@{{ confirmingPlan.interval | capitalize }})</strong>'
                            ])
                        </p>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('No, Go Back')</button>

                        <button type="button" class="btn btn-primary" @click="approvePlanUpdate">@lang('Yes, I\'m Sure')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-update-subscription>
