<spark-kiosk-metrics :user="user" inline-template>
    <!-- The Landsman™ -->
    <div>

        <div class="card card-default mb-4">
            <div class="card-header">
                <h2 class="card-title mb-0">{{__('Metrics')}}</h2>
            </div>
            <div class="card-body">
                <div class="metrics">
                    <div class="metric">
                        <div class="mr-3">
                            <i class="metric-icon">
                                <svg width="14" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 20">
                                    <path fill="#4AA2E2" d="M7 3v2c-2.761424 0-5 2.238576-5 5 0 1.380712.559644 2.630712 1.464466 3.535534l-1.414213 1.414213C.783502 13.682997 0 11.932997 0 10c0-3.865993 3.134007-7 7-7zm4.949747 2.050253C13.216498 6.317003 14 8.067003 14 10c0 3.865993-3.134007 7-7 7v-2c2.761424 0 5-2.238576 5-5 0-1.380712-.559644-2.630712-1.464466-3.535534l1.414213-1.414213zM7 20l-4-4 4-4v8zM7 8V0l4 4-4 4z"
                                    />
                                </svg>
                            </i>
                        </div>
                        <div>
                            <h2 class="metric-title mb-0">
                                {{__('Recurring Revenue')}}
                            </h2>
                            <p class="metric-stat mb-0">
                                @{{ monthlyRecurringRevenue | currency }}
                                <span class="metric-unit">/ mo</span>
                            </p>
                            <p class="metric-stat-sm mb-0">
                                @{{ yearlyRecurringRevenue | currency }} / yr
                            </p>
                        </div>
                    </div>
                    <div class="metric">
                        <div class="mr-3">
                            <i class="metric-icon">
                                <svg width="20" height="12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 12">
                                    <path fill="#4AA2E2" fill-rule="evenodd" d="M16.414214 4.707107L19.707107 8V0h-8L15 3.292893 9.707107 8.585786l-4-4L0 10.292893l1.414214 1.414214 4.292893-4.292893 4 4 6.707107-6.707107z"
                                    />
                                </svg>
                            </i>
                        </div>
                        <div>
                            <h2 class="metric-title mb-0">
                                {{__('Total Volume')}}
                            </h2>
                            <p class="metric-stat">
                                @{{ totalVolume | currency }}
                            </p>
                        </div>
                    </div>
                    <div class="metric">
                        <div class="mr-3">
                            <i class="metric-icon">
                                <svg width="19" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19 20">
                                    <path fill="#4AA2E2" d="M6.109 8c-2.209139 0-4-1.790861-4-4s1.790861-4 4-4 4 1.790861 4 4-1.790861 4-4 4zm0 1c2.148 0 4.199.396 6.109 1.086L11.109 16h-1.25l-.75 4h-6l-.75-4h-1.25L0 10.086C1.91 9.396 3.961 9 6.109 9zm8.315.171c1.312.175 2.584.477 3.794.915L17.109 16h-1.25l-.75 4h-3.965l.375-2h1.25l1.655-8.829zM12.109 0c2.209 0 4 1.791 4 4s-1.791 4-4 4c-.469 0-.911-.096-1.329-.243.83-1.029 1.329-2.335 1.329-3.757 0-1.422-.499-2.728-1.329-3.757.418-.147.861-.243 1.329-.243z"
                                    />
                                </svg>
                            </i>
                        </div>
                        <div>
                            <h2 class="metric-title mb-0">
                                @if(Spark::teamTrialDays())
                                    {{__('Teams Currently Trialing')}}
                                @else
                                    {{__('Users Currently Trialing')}}
                                @endif
                            </h2>
                            <p class="metric-stat">
                                @{{ totalTrialUsers }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Recurring Revenue Chart -->
        <div class="row" v-show="indicators.length > 0">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">{{__('Monthly Recurring Revenue')}}</div>

                    <div class="card-body">
                        <canvas id="monthlyRecurringRevenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Yearly Recurring Revenue Chart -->
        <div class="row" v-show="indicators.length > 0">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">{{__('Yearly Recurring Revenue')}}</div>

                    <div class="card-body">
                        <canvas id="yearlyRecurringRevenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-show="indicators.length > 0">
            <!-- Daily Volume Chart -->
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">{{__('Daily Volume')}}</div>

                    <div class="card-body">
                        <canvas id="dailyVolumeChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Daily New Users Chart -->
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">{{__('New Users')}}</div>

                    <div class="card-body">
                        <canvas id="newUsersChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscribers Per Plan -->
        <div class="row" v-if="plans.length > 0">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">{{__('Subscribers')}}</div>

                    <div class="table-responsive">
                        <table class="table table-valign-middle mb-0">
                            <thead>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Subscribers')}}</th>
                            <th>{{__('Trialing')}}</th>
                            </thead>

                            <tbody>
                            <tr v-if="genericTrialUsers">
                                <td>
                                    <div class="btn-table-align">
                                        {{__('On Generic Trial')}}
                                    </div>
                                </td>

                                <td>
                                    <div class="btn-table-align">
                                        {{__('N/A')}}
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
