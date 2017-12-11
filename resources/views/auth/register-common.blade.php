<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Coupon -->
        <div class="alert alert-success" v-if="coupon">
            <?php echo __('The coupon :value discount will be applied to your subscription!', ['value' => '{{ discount }}']); ?>
        </div>

        <!-- Invalid Coupon -->
        <div class="alert alert-danger" v-if="invalidCoupon">
            {{__('Whoops! This coupon code is invalid.')}}
        </div>

        <!-- Invitation -->
        <div class="alert alert-success" v-if="invitation">
            <?php echo __('teams.we_found_invitation_to_team', ['teamName' => '{{ invitation.team.name }}']); ?>
        </div>

        <!-- Invalid Invitation -->
        <div class="alert alert-danger" v-if="invalidInvitation">
            {{__('Whoops! This invitation code is invalid.')}}
        </div>
    </div>
</div>

<!-- Plan Selection -->
<div class="row justify-content-center" v-if="paidPlans.length > 0">
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-header">
                <div class="pull-left" :class="{'btn-table-align': hasMonthlyAndYearlyPlans}">
                    {{__('Subscription')}}
                </div>

                <!-- Interval Selector Button Group -->
                <div class="pull-right">
                    <div class="btn-group btn-group-sm" v-if="hasMonthlyAndYearlyPlans" style="padding-top: 2px;">
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
                <div class="alert alert-danger m-4" v-if="registerForm.errors.has('plan')">
                    @{{ registerForm.errors.get('plan') }}
                </div>

                <!-- European VAT Notice -->
                @if (Spark::collectsEuropeanVat())
                    <p class="m-4">
                        {{__('All subscription plan prices are excluding applicable VAT.')}}
                    </p>
                @endif

                <table class="table table-responsive-sm table-valign-middle mb-0 ">
                    <thead></thead>
                    <tbody>
                        <tr v-for="plan in plansForActiveInterval">
                            <!-- Plan Name -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="radio-select mr-2" @click="selectPlan(plan)"
                                    :class="{'radio-select-selected': isSelected(plan)}"></i>
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
                                <span v-if="plan.price == 0" class="table-plan-text">
                                    {{__('Free')}}
                                </span>

                                <span v-else class="table-plan-text">
                                    <strong class="table-plan-price">@{{ plan.price | currency }}</strong>
                                    @{{ plan.type == 'user' && spark.chargesUsersPerSeat ? '/ '+ spark.seatName : '' }}
                                    @{{ plan.type == 'team' && spark.chargesTeamsPerSeat ? '/ '+ spark.teamSeatName : '' }}
                                    / @{{ __(plan.interval) | capitalize }}
                                </span>
                            </td>

                            <!-- Trial Days -->
                            <td class="table-plan-price table-plane-text text-right">
                                <span v-if="plan.trialDays && ! hasSubscribed(plan)">
                                    <?php echo __(':trialDays Day Trial', ['trialDays' => '{{ plan.trialDays }}']); ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Basic Profile -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-header">
                <span v-if="paidPlans.length > 0">
                    {{__('Profile')}}
                </span>

                <span v-else>
                    {{__('Register')}}
                </span>
            </div>

            <div class="card-body">
                <!-- Generic Error Message -->
                <div class="alert alert-danger" v-if="registerForm.errors.has('form')">
                    @{{ registerForm.errors.get('form') }}
                </div>

                <!-- Invitation Code Error -->
                <div class="alert alert-danger" v-if="registerForm.errors.has('invitation')">
                    @{{ registerForm.errors.get('invitation') }}
                </div>

                <!-- Registration Form -->
                @include('spark::auth.register-common-form')
            </div>
        </div>
    </div>
</div>
