<spark-kiosk-metrics :user="user" inline-template>
    <!-- The Landsman™ -->
    <div>
        <div class="row">
            <!-- Monthly Recurring Revenue -->
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Monthly Recurring Revenue</div>

                    <div class="panel-body text-center">
                        <div style="font-size: 24px;">
                            @{{ monthlyRecurringRevenue | currency }}
                        </div>

                        <!-- Compared To Last Month -->
                        <div v-if="monthlyChangeInMonthlyRecurringRevenue" style="font-size: 12px;">
                            @{{ monthlyChangeInMonthlyRecurringRevenue }}% From Last Month
                        </div>

                        <!-- Compared To Last Year -->
                        <div v-if="yearlyChangeInMonthlyRecurringRevenue" style="font-size: 12px;">
                            @{{ yearlyChangeInMonthlyRecurringRevenue }}% From Last Year
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yearly Recurring Revenue -->
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Yearly Recurring Revenue</div>

                    <div class="panel-body text-center">
                        <div style="font-size: 24px;">
                            @{{ yearlyRecurringRevenue | currency }}
                        </div>

                        <!-- Compared To Last Month -->
                        <div v-if="monthlyChangeInYearlyRecurringRevenue" style="font-size: 12px;">
                            @{{ monthlyChangeInYearlyRecurringRevenue }}% From Last Month
                        </div>

                        <!-- Compared To Last Year -->
                        <div v-if="yearlyChangeInYearlyRecurringRevenue" style="font-size: 12px;">
                            @{{ yearlyChangeInYearlyRecurringRevenue }}% From Last Year
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Total Volume -->
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">Total Volume</div>

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
                    <div class="panel-heading text-center">Users Currently Trialing</div>

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
                    <div class="panel-heading">Monthly Recurring Revenue</div>

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
                    <div class="panel-heading">Yearly Recurring Revenue</div>

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
                    <div class="panel-heading">Daily Volume</div>

                    <div class="panel-body">
                        <canvas id="dailyVolumeChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Daily New Users Chart -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">New Users</div>

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
                    <div class="panel-heading">Subscribers</div>

                    <div class="panel-body">
                        <table class="table table-borderless m-b-none">
                            <thead>
                                <th>Name</th>
                                <th>Subscribers</th>
                                <th>Trialing</th>
                            </thead>

                            <tbody>
                                <tr v-if="genericTrialUsers">
                                    <td>
                                        <div class="btn-table-align">
                                            On Generic Trial
                                        </div>
                                    </td>

                                    <td>
                                        <div class="btn-table-align">
                                            N/A
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
