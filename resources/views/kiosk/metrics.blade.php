<spark-kiosk-metrics :user="user" inline-template>
    <!-- The Landsman™ -->
    <div>
        <div class="row">
            <!-- Monthly Recurring Revenue -->
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">@lang('Monthly Recurring Revenue')</div>

                    <div class="panel-body text-center">
                        <div style="font-size: 24px;">
                            @{{ monthlyRecurringRevenue | currency }}
                        </div>

                        <!-- Compared To Last Month -->
                        <div v-if="monthlyChangeInMonthlyRecurringRevenue" style="font-size: 12px;">
                            @{{ monthlyChangeInMonthlyRecurringRevenue }}% @lang('From Last Month')
                        </div>

                        <!-- Compared To Last Year -->
                        <div v-if="yearlyChangeInMonthlyRecurringRevenue" style="font-size: 12px;">
                            @{{ yearlyChangeInMonthlyRecurringRevenue }}% @lang('From Last Year')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yearly Recurring Revenue -->
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">@lang('Yearly Recurring Revenue')</div>

                    <div class="panel-body text-center">
                        <div style="font-size: 24px;">
                            @{{ yearlyRecurringRevenue | currency }}
                        </div>

                        <!-- Compared To Last Month -->
                        <div v-if="monthlyChangeInYearlyRecurringRevenue" style="font-size: 12px;">
                            @{{ monthlyChangeInYearlyRecurringRevenue }}% @lang('From Last Month')
                        </div>

                        <!-- Compared To Last Year -->
                        <div v-if="yearlyChangeInYearlyRecurringRevenue" style="font-size: 12px;">
                            @{{ yearlyChangeInYearlyRecurringRevenue }}% @lang('From Last Year')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Total Volume -->
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">@lang('Total Volume')</div>

                    <div class="panel-body text-center">
                        <span style="font-size: 24px;">
                            @{{ totalVolume | currency }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Total Trial Users -->
            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading text-center">@lang('Users Currently Trialing')</div>

                    <div class="panel-body text-center">
                        <span style="font-size: 24px;">
                            @{{ totalTrialUsers }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Recurring Revenue Chart -->
        <div class="row" v-show="indicators.length > 0">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('Monthly Recurring Revenue')</div>

                    <div class="panel-body">
                        <canvas id="monthlyRecurringRevenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Yearly Recurring Revenue Chart -->
        <div class="row" v-show="indicators.length > 0">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('Yearly Recurring Revenue')</div>

                    <div class="panel-body">
                        <canvas id="yearlyRecurringRevenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-show="indicators.length > 0">
            <!-- Daily Volume Chart -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('Daily Volume')</div>

                    <div class="panel-body">
                        <canvas id="dailyVolumeChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Daily New Users Chart -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('New Users')</div>

                    <div class="panel-body">
                        <canvas id="newUsersChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscribers Per Plan -->
        <div class="row" v-if="plans.length > 0">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">@lang('Subscribers')</div>

                    <div class="panel-body">
                        <table class="table table-borderless m-b-none">
                            <thead>
                                <th>@lang('Name')</th>
                                <th>@lang('Subscribers')</th>
                                <th>@lang('Trialing')</th>
                            </thead>

                            <tbody>
                                <tr v-if="genericTrialUsers">
                                    <td>
                                        <div class="btn-table-align">
                                            @lang('On Generic Trial')
                                        </div>
                                    </td>

                                    <td>
                                        <div class="btn-table-align">
                                            @lang('N/A')
                                        </div>
                                    </td>

                                    <td>
                                        <div class="btn-table-align">
                                            @{{ genericTrialUsers }}
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="plan in plans">
                                    <!-- Plan Name -->
                                    <td>
                                        <div class="btn-table-align">
                                            @{{ plan.name }} (@{{ plan.interval | capitalize }})
                                        </div>
                                    </td>

                                    <!-- Subscriber Count -->
                                    <td>
                                        <div class="btn-table-align">
                                            @{{ plan.count }}
                                        </div>
                                    </td>

                                    <!-- Trialing Count -->
                                    <td>
                                        <div class="btn-table-align">
                                            @{{ plan.trialing }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</spark-kiosk-metrics>
