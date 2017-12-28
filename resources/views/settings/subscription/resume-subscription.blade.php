<spark-resume-subscription :user="user" :team="team"
                :plans="plans" :billable-type="billableType" inline-template>

    <div class="card card-default">
        <div class="card-header">
            <div class="float-left" :class="{'btn-table-align': hasMonthlyAndYearlyPlans}">
                {{__('Resume Subscription')}}
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
            <div class="alert alert-danger mb-4" v-if="planForm.errors.has('plan')">
                @{{ planForm.errors.get('plan') }}
            </div>

            <!-- Cancellation Information -->
            <div class="m-4">
                <?php echo __('You have cancelled your subscription to the :planName plan.', ['planName' => '{{ activePlan.name }} ({{ activePlan.interval | capitalize }})']); ?>
            </div>

            <div class="m-4">
                <?php echo __('The benefits of your subscription will continue until your current billing period ends on :date. You may resume your subscription at no extra cost until the end of the billing period.', ['date' => '{{ activeSubscription.ends_at | date }}']); ?>
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
                    <tr v-for="plan in paidPlansForActiveInterval">
                        <!-- Plan Name -->
                        <td>
                            <div class="d-flex align-items-center">
                                @{{ plan.name }}
                            </div>
                        </td>

                        <!-- Plan Features Button -->
                        <td>
                            <button class="btn btn-default" @click="showPlanDetails(plan)">
                                <i class="fa fa-btn fa-star-o"></i> {{__('Features')}}
                            </button>
                        </td>

                        <!-- Plan Price -->
                        <td>
                            <div class="btn-table-align">
                                <strong class="table-plan-price">@{{ priceWithTax(plan) | currency }}</strong>
                                @{{ plan.type == 'user' && spark.chargesUsersPerSeat ? '/ '+ spark.seatName : '' }}
                                @{{ plan.type == 'user' && spark.chargesUsersPerTeam ? '/ '+ __('teams.team') : '' }}
                                @{{ plan.type == 'team' && spark.chargesTeamsPerSeat ? '/ '+ spark.teamSeatName : '' }}
                                @{{ plan.type == 'team' && spark.chargesTeamsPerMember ? '/ '+ __('teams.member') : '' }}
                                / @{{ __(plan.interval) | capitalize }}
                            </div>
                        </td>

                        <!-- Plan Select Button -->
                        <td class="text-right">
                            <button class="btn btn-plan"
                                    v-bind:class="{'btn-default': ! isActivePlan(plan), 'btn-warning': isActivePlan(plan)}"
                                    @click="updateSubscription(plan)"
                                    :disabled="selectingPlan">

                                <span v-if="selectingPlan === plan">
                                    <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Resuming')}}
                                </span>

                                <span v-if="! isActivePlan(plan) && selectingPlan !== plan">
                                    {{__('Switch')}}
                                </span>

                                <span v-if="isActivePlan(plan) && selectingPlan !== plan">
                                    {{__('Resume')}}
                                </span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</spark-resume-subscription>
