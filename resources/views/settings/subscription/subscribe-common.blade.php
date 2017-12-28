<div class="card card-default">
    <div class="card-header">
        <div class="float-left" :class="{'btn-table-align': hasMonthlyAndYearlyPlans}">
            {{__('Subscribe')}}
        </div>

        <!-- Interval Selector Button Group -->
        <div class="float-right">
            <div class="btn-group btn-group-sm" role="group" v-if="hasMonthlyAndYearlyPaidPlans">
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
        <!-- European VAT Notice -->
        @if (Spark::collectsEuropeanVat())
            <p class="m-4">
                {{__('All subscription plan prices are excluding applicable VAT.')}}
            </p>
        @endif

        <!-- Plan Error Message -->
        <div class="alert alert-danger m-4" v-if="form.errors.has('plan')">
            @{{ form.errors.get('plan') }}
        </div>

        <table class="table table-responsive-sm table-valign-middle mb-0 ">
            <thead></thead>
            <tbody>
                <tr v-for="plan in paidPlansForActiveInterval">
                    <!-- Plan Name -->
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="radio-select mr-2" @click="selectPlan(plan)"
                               :class="{'radio-select-selected': selectedPlan == plan, invisible: form.busy}"></i>
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
                        <span class="table-plan-text">
                            <strong class="table-plan-price">@{{ plan.price | currency }}</strong>
                            @{{ plan.type == 'user' && spark.chargesUsersPerSeat ? '/ '+ spark.seatName : '' }}
                            @{{ plan.type == 'user' && spark.chargesUsersPerTeam ? '/ '+ __('teams.team') : '' }}
                            @{{ plan.type == 'team' && spark.chargesTeamsPerSeat ? '/ '+ spark.teamSeatName : '' }}
                            @{{ plan.type == 'team' && spark.chargesTeamsPerMember ? '/ '+ __('teams.member') : '' }}
                            / @{{ __(plan.interval) | capitalize }}
                        </div>
                    </td>

                    <!-- Trial Days -->
                    <td class="table-plan-price table-plane-text text-right">
                        <span v-if="plan.trialDays && ! hasSubscribed(plan)">
                            @{{ plan.trialDays}} {{__('Day Trial')}}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
