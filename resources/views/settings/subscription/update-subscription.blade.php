<spark-update-subscription :user="user" :team="team"
                :plans="plans" :billable-type="billableType" inline-template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                <div class="float-left" :class="{'btn-table-align': hasMonthlyAndYearlyPlans}">
                    {{__('Update Subscription')}}
                </div>

                <!-- Interval Selector Button Group -->
                <div class="float-right">
                    <div class="btn-group btn-group-sm" v-if="hasMonthlyAndYearlyPlans">
                        <!-- Monthly Plans -->
                        <button type="button" class="btn btn-light"
                                @click="showMonthlyPlans"
                                :class="{'active': showingMonthlyPlans}">

                            {{__('Monthly')}}
                        </button>

                        <!-- Yearly Plans -->
                        <button type="button" class="btn btn-light"
                                @click="showYearlyPlans"
                                :class="{'active': showingYearlyPlans}">

                            {{__('Yearly')}}
                        </button>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="table-responsive">
                <!-- Plan Error Message - In General Will Never Be Shown -->
                <div class="alert alert-danger m-4" v-if="planForm.errors.has('plan')">
                    @{{ planForm.errors.get('plan') }}
                </div>

                <!-- Current Subscription (Active) -->
                <div class="m-4" v-if="activePlan.active">
                    <?php echo __('You are currently subscribed to the :planName plan.', ['planName' => '{{ activePlan.name }} ({{ activePlan.interval | capitalize }})']); ?>
                </div>

                <!-- Current Subscription (Archived) -->
                <div class="alert alert-warning m-4" v-if=" ! activePlan.active">
                    <?php echo __('You are currently subscribed to the :planName plan.', ['planName' => '{{ activePlan.name }} ({{ activePlan.interval | capitalize }})']); ?>
                    {{__('This plan has been discontinued, but you may continue your subscription to this plan as long as you wish. If you cancel your subscription and later want to begin a new subscription, you will need to choose from one of the active plans listed below.')}}
                </div>

                <!-- European VAT Notice -->
                @if (Spark::collectsEuropeanVat())
                    <p class="m-4">
                        {{__('All subscription plan prices include applicable VAT.')}}
                    </p>
                @endif

                <table class="table table-responsive-sm table-valign-middle mb-0 ">
                    <thead></thead>
                    <tbody>
                        <tr v-for="plan in plansForActiveInterval">
                            <!-- Plan Name -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="radio-select mr-2" @click="!isActivePlan(plan) ? confirmPlanUpdate(plan) : 0"
                                    :class="{'radio-select-selected': isActivePlan(plan), invisible: selectingPlan}"></i>
                                    @{{ plan.name }}
                                </div>
                            </td>

                            <!-- Plan Features Button -->
                            <td>
                                <button class="btn btn-default" @click="showPlanDetails(plan)">
                                    {{__('Features')}}
                                </button>
                            </td>

                            <!-- Plan Price -->
                            <td>
                                <div class="btn-table-align">
                                    <span v-if="plan.price == 0">
                                        {{__('Free')}}
                                    </span>

                                    <span v-else>
                                        <strong class="table-plan-price">@{{ priceWithTax(plan) | currency }}</strong>
                                        @{{ plan.type == 'user' && spark.chargesUsersPerSeat ? '/ '+ spark.seatName : '' }}
                                        @{{ plan.type == 'user' && spark.chargesUsersPerTeam ? '/ '+ __('teams.team') : '' }}
                                        @{{ plan.type == 'team' && spark.chargesTeamsPerSeat ? '/ '+ spark.teamSeatName : '' }}
                                        @{{ plan.type == 'team' && spark.chargesTeamsPerMember ? '/ '+ __('teams.member') : '' }}
                                        / @{{ __(plan.interval) | capitalize }}
                                    </span>
                                </div>
                            </td>

                            <!-- Plan Select Button -->
                            <td class="text-right">
                                <span v-if="selectingPlan && selectingPlan === plan">
                                    <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Updating')}}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Confirm Plan Update Modal -->
        <div class="modal" id="modal-confirm-plan-update" tabindex="-2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" v-if="confirmingPlan">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{__('Update Subscription')}}
                        </h5>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p>
                            <?php echo __('Are you sure you want to switch to the :planName plan?', ['planName' => '<strong>{{ confirmingPlan.name }} ({{ confirmingPlan.interval | capitalize }})</strong>']) ?>
                        </p>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('No, Go Back')}}</button>

                        <button type="button" class="btn btn-primary" @click="approvePlanUpdate">{{__('Yes, I\'m Sure')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-update-subscription>
