<!-- Coupon -->
<div class="row" v-if="coupon">
    <div class="col-md-8 col-md-offset-2">
        <div class="card card-success">
            <div class="card-header">Discount</div>

            <div class="card-body">
                The coupon's @{{ discount }} discount will be applied to your subscription!
            </div>
        </div>
    </div>
</div>

<!-- Invalid Coupon -->
<div class="row" v-if="invalidCoupon">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-danger">
            Whoops! This coupon code is invalid.
        </div>
    </div>
</div>

<!-- Invitation -->
<div class="row" v-if="invitation">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-success">
            We found your invitation to the <strong>@{{ invitation.team.name }}</strong> {{ Spark::teamString() }}!
        </div>
    </div>
</div>

<!-- Invalid Invitation -->
<div class="row" v-if="invalidInvitation">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-danger">
            Whoops! This invitation code is invalid.
        </div>
    </div>
</div>

<!-- Plan Selection -->
<div class="row justify-content-center" v-if="paidPlans.length > 0">
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-header">
                <div class="pull-left" :class="{'btn-table-align': hasMonthlyAndYearlyPlans}">
                    Subscription
                </div>

                <!-- Interval Selector Button Group -->
                <div class="pull-right">
                    <div class="btn-group btn-group-sm" v-if="hasMonthlyAndYearlyPlans" style="padding-top: 2px;">
                        <!-- Monthly Plans -->
                        <button type="button" class="btn btn-light"
                                @click="showMonthlyPlans"
                                :class="{'active': showingMonthlyPlans}">

                            Monthly
                        </button>

                        <!-- Yearly Plans -->
                        <button type="button" class="btn btn-light"
                                @click="showYearlyPlans"
                                :class="{'active': showingYearlyPlans}">

                            Yearly
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
                        All subscription plan prices are excluding applicable VAT.
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
                                Features
                                </button>
                            </td>

                            <!-- Plan Price -->
                            <td>
                                <span v-if="plan.price == 0" class="table-plan-text">
                                    Free
                                </span>

                                <span v-else class="table-plan-text">
                                    <strong class="table-plan-price">@{{ plan.price | currency }}</strong> / @{{ plan.interval | capitalize }}
                                </span>
                            </td>

                            <!-- Trial Days -->
                            <td class="table-plan-price table-plane-text text-right">
                                <span v-if="plan.trialDays && ! hasSubscribed(plan)">
                                    @{{ plan.trialDays}} Day Trial
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
                    Profile
                </span>

                <span v-else>
                    Register
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
