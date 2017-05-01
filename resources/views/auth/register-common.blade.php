<!-- Coupon -->
<div class="row" v-if="coupon">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-success">
            <div class="panel-heading">@lang('Discount')</div>

            <div class="panel-body">
                @lang('The coupon\'s :discount discount will be applied to your subscription!', ['discount' => '@{{ discount }}'])
            </div>
        </div>
    </div>
</div>

<!-- Invalid Coupon -->
<div class="row" v-if="invalidCoupon">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-danger">
            @lang('Whoops! This coupon code is invalid.')
        </div>
    </div>
</div>

<!-- Invitation -->
<div class="row" v-if="invitation">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-success">
            @lang('We found your invitation to the :name :team!', ['name' => '<strong>@{{ invitation.team.name }}</strong>', 'team' => Spark::teamString()])
        </div>
    </div>
</div>

<!-- Invalid Invitation -->
<div class="row" v-if="invalidInvitation">
    <div class="col-md-8 col-md-offset-2">
        <div class="alert alert-danger">
            @lang('Whoops! This invitation code is invalid.')
        </div>
    </div>
</div>

<!-- Plan Selection -->
<div class="row" v-if="paidPlans.length > 0">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left" :class="{'btn-table-align': hasMonthlyAndYearlyPlans}">
                    @lang('Subscription')
                </div>

                <!-- Interval Selector Button Group -->
                <div class="pull-right">
                    <div class="btn-group" v-if="hasMonthlyAndYearlyPlans" style="padding-top: 2px;">
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

            <div class="panel-body spark-row-list">
                <!-- Plan Error Message - In General Will Never Be Shown -->
                <div class="alert alert-danger" v-if="registerForm.errors.has('plan')">
                    @{{ registerForm.errors.get('plan') }}
                </div>

                <!-- European VAT Notice -->
                @if (Spark::collectsEuropeanVat())
                    <p class="p-b-md">
                        @lang('All subscription plan prices are excluding applicable VAT.')
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
                                        @{{ plan.price | currency }} / @{{ plan.interval | capitalize }}
                                    </span>
                                </div>
                            </td>

                            <!-- Trial Days -->
                            <td>
                                <div class="btn-table-align" v-if="plan.trialDays">
                                    @lang(':days Day Trial', ['days' => '@{{ plan.trialDays}}'])
                                </div>
                            </td>

                            <!-- Plan Select Button -->
                            <td class="text-right">
                                <button class="btn btn-primary btn-plan" v-if="isSelected(plan)" disabled>
                                    <i class="fa fa-btn fa-check"></i>@lang('Selected')
                                </button>

                                <button class="btn btn-primary-outline btn-plan" @click="selectPlan(plan)" v-else>
                                    @lang('Select')
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Basic Profile -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span v-if="paidPlans.length > 0">
                    @lang('Profile')
                </span>

                <span v-else>
                    @lang('Register')
                </span>
            </div>

            <div class="panel-body">
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
