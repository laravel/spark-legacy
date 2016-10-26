@extends('spark::layouts.app')

@section('scripts')
    @if (Spark::billsUsingStripe())
        <script src="https://js.stripe.com/v2/"></script>
    @else
        <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
    @endif
@endsection

@section('content')
<spark-team-settings :user="user" :team-id="{{ $team->id }}" inline-template>
    <div class="spark-screen container">
        <div class="row">
            <!-- Tabs -->
            <div class="col-md-4">
                <div class="panel panel-default panel-flush">
                    <div class="panel-heading">
                        <span v-if="team">
                            @{{ team.name }} {{ ucfirst(Spark::teamString()) }} Settings
                        </span>
                    </div>

                    <div class="panel-body">
                        <div class="spark-settings-tabs">
                            <ul class="nav spark-settings-stacked-tabs" role="tablist">
                                <!-- Owner Settings -->
                                @if (Auth::user()->ownsTeam($team))
                                    <li role="presentation" class="active">
                                        <a href="#owner" aria-controls="owner" role="tab" data-toggle="tab">
                                            <i class="fa fa-fw fa-btn fa-edit"></i>{{ ucfirst(Spark::teamString()) }} Profile
                                        </a>
                                    </li>
                                @endif

                                <!-- Membership -->
                                @if (Auth::user()->ownsTeam($team))
                                <li role="presentation">
                                @else
                                <li role="presentation" class="active">
                                @endif
                                    <a href="#membership" aria-controls="membership" role="tab" data-toggle="tab">
                                        <i class="fa fa-fw fa-btn fa-users"></i>Membership
                                    </a>
                                </li>

                                <!-- View All Teams -->
                                <li role="presentation">
                                    <a href="/settings#/{{str_plural(Spark::teamString())}}">
                                        <i class="fa fa-fw fa-btn fa-arrow-left"></i>View All {{ ucfirst(str_plural(Spark::teamString())) }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Billing Tabs -->
                @if (Spark::canBillTeams() && Auth::user()->ownsTeam($team))
                    <div class="panel panel-default panel-flush">
                        <div class="panel-heading">
                            {{ ucfirst(Spark::teamString()) }} Billing
                        </div>

                        <div class="panel-body">
                            <div class="spark-settings-tabs">
                                <ul class="nav spark-settings-stacked-tabs" role="tablist">
                                    @if (Spark::hasPaidTeamPlans())
                                        <!-- Subscription Link -->
                                        <li role="presentation">
                                            <a href="#subscription" aria-controls="subscription" role="tab" data-toggle="tab">
                                                <i class="fa fa-fw fa-btn fa-shopping-bag"></i>Subscription
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Payment Method Link -->
                                    <li role="presentation">
                                        <a href="#payment-method" aria-controls="payment-method" role="tab" data-toggle="tab">
                                            <i class="fa fa-fw fa-btn fa-credit-card"></i>Payment Method
                                        </a>
                                    </li>

                                    <!-- Invoices Link -->
                                    <li role="presentation">
                                        <a href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab">
                                            <i class="fa fa-fw fa-btn fa-history"></i>Invoices
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tab Panels -->
            <div class="col-md-8">
                <div class="tab-content">
                    <!-- Owner Information -->
                    @if (Auth::user()->ownsTeam($team))
                        <div role="tabpanel" class="tab-pane active" id="owner">
                            @include('spark::settings.teams.team-profile')
                        </div>
                    @endif

                    <!-- Membership -->
                    @if (Auth::user()->ownsTeam($team))
                    <div role="tabpanel" class="tab-pane" id="membership">
                    @else
                    <div role="tabpanel" class="tab-pane active" id="membership">
                    @endif
                        <div v-if="team">
                            @include('spark::settings.teams.team-membership')
                        </div>
                    </div>

                    <!-- Billing Tab Panes -->
                    @if (Spark::canBillTeams() && Auth::user()->ownsTeam($team))
                        @if (Spark::hasPaidTeamPlans())
                            <!-- Subscription -->
                            <div role="tabpanel" class="tab-pane" id="subscription">
                                <div v-if="user && team">
                                    @include('spark::settings.subscription')
                                </div>
                            </div>
                        @endif

                        <!-- Payment Method -->
                        <div role="tabpanel" class="tab-pane" id="payment-method">
                            <div v-if="user && team">
                                @include('spark::settings.payment-method')
                            </div>
                        </div>

                        <!-- Invoices -->
                        <div role="tabpanel" class="tab-pane" id="invoices">
                            <div v-if="user && team">
                                @include('spark::settings.invoices')
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</spark-team-settings>
@endsection
