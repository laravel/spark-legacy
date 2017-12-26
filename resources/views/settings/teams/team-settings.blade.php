@extends('spark::layouts.app')

@section('scripts')
    @if (Spark::billsUsingStripe())
        <script src="https://js.stripe.com/v3/"></script>
    @else
        <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
    @endif
@endsection

@section('content')
<spark-team-settings :user="user" :team-id="{{ $team->id }}" inline-template>
    <div class="spark-screen container">
        <div class="row">
            <!-- Tabs -->
            <div class="col-md-3 spark-settings-tabs">
                <aside>
                    <h3 class="nav-heading ">
                        {{__('teams.team_settings')}}
                    </h3>
                    <ul class="nav flex-column mb-4 ">
                        @if (Auth::user()->ownsTeam($team))
                            <li class="nav-item ">
                                <a class="nav-link" href="#owner" aria-controls="owner" role="tab" data-toggle="tab">
                                    <svg class="icon-20 " viewBox="0 0 20 20 " xmlns="http://www.w3.org/2000/svg ">
                                        <path d="M10 20C4.4772 20 0 15.5228 0 10S4.4772 0 10 0s10 4.4772 10 10-4.4772 10-10 10zm0-17C8.343 3 7
                  4.343 7 6v2c0 1.657 1.343 3 3 3s3-1.343 3-3V6c0-1.657-1.343-3-3-3zM3.3472 14.4444C4.7822 16.5884 7.2262 18 10
                  18c2.7737 0 5.2177-1.4116 6.6528-3.5556C14.6268 13.517 12.3738 13 10 13s-4.627.517-6.6528 1.4444z "></path>
                                    </svg>
                                    {{__('teams.team_profile')}}
                                </a>
                            </li>
                        @endif

                        <li class="nav-item ">
                            <a class="nav-link" href="#membership" aria-controls="membership" role="tab" data-toggle="tab">
                                <svg class="icon-20 " viewBox="0 0 20 20 " xmlns="http://www.w3.org/2000/svg ">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM6.7 9.29L9 11.6l4.3-4.3 1.4 1.42L9 14.4l-3.7-3.7 1.4-1.42z"/>
                                </svg>
                                {{__('Membership')}}
                            </a>
                        </li>

                            @if (Spark::createsAdditionalTeams())
                                <li class="nav-item ">
                                    <a class="nav-link" href="/settings#/{{str_plural(Spark::teamsPrefix())}}">
                                        <svg class="icon-20 " viewBox="0 0 20 20 " xmlns="http://www.w3.org/2000/svg ">
                                            <path d="M6 8C4 8 2 6.2 2 4s2-4 4-4c2.3 0 4 1.8 4 4S8.4 8 6 8zm0 1c2.3 0 4.3.4 6.2 1l-1 6H9.8l-1 4H3l-.6-4H1l-1-6c2-.6
              4-1 6-1zm8.4.2c1.3 0 2.6.4 3.8 1l-1 5.8H16l-1 4h-4l.4-2h1.3l1.6-8.8zM12 0c2.3 0 4 1.8 4 4s-1.7 4-4 4c-.4 0-.8
              0-1.2-.2.8-1 1.3-2.4 1.3-3.8s0-2.7-1-3.8l1-.2z " />
                                        </svg>
                                        {{__('teams.view_all_teams')}}
                                    </a>
                                </li>
                            @else
                                <li class="nav-item ">
                                    <a class="nav-link" href="/settings">
                                        <svg class="icon-20 " viewBox="0 0 20 20 " xmlns="http://www.w3.org/2000/svg ">
                                            <path d="M3.94 6.5L2.22 3.64l1.42-1.42L6.5 3.94c.52-.3 1.1-.54 1.7-.7L9 0h2l.8 3.24c.6.16 1.18.4 1.7.7l2.86-1.72 1.42 1.42-1.72 2.86c.3.52.54 1.1.7 1.7L20 9v2l-3.24.8c-.16.6-.4 1.18-.7 1.7l1.72 2.86-1.42 1.42-2.86-1.72c-.52.3-1.1.54-1.7.7L11 20H9l-.8-3.24c-.6-.16-1.18-.4-1.7-.7l-2.86 1.72-1.42-1.42 1.72-2.86c-.3-.52-.54-1.1-.7-1.7L0 11V9l3.24-.8c.16-.6.4-1.18.7-1.7zM10 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                        {{__('Your Settings')}}
                                    </a>
                                </li>
                            @endif
                    </ul>
                </aside>

                @if (Spark::canBillTeams() && Auth::user()->ownsTeam($team))
                    <aside>
                        <h3 class="nav-heading ">
                            {{__('teams.team_billing')}}
                        </h3>
                        <ul class="nav flex-column mb-4 ">
                            @if (Spark::hasPaidTeamPlans())
                                <li class="nav-item ">
                                    <a class="nav-link" href="#subscription" aria-controls="subscription" role="tab" data-toggle="tab">
                                        <svg class="icon-20 " xmlns="http://www.w3.org/2000/svg " viewBox="0 0 14 20 ">
                                            <path d="M7 3v2c-2.8 0-5 2.2-5 5 0 1.4.6 2.6 1.5 3.5L2 15c-1.2-1.3-2-3-2-5 0-4 3-7 7-7zm5 2c1.2 1.3 2 3
              2 5 0 4-3 7-7 7v-2c2.8 0 5-2.2 5-5 0-1.4-.6-2.6-1.5-3.5L12 5zM7 20l-4-4 4-4v8zM7 8V0l4 4-4 4z " />
                                        </svg>
                                        {{__('Subscription')}}
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="#payment-method" aria-controls="payment-method" role="tab" data-toggle="tab">
                                        <svg class="icon-20 " xmlns="http://www.w3.org/2000/svg " viewBox="0 0 20 16 ">
                                            <path d="M18 4V2H2v2h16zm0 4H2v6h16V8zM0 2c0-1 1-2 2-2h16c1 0 2 1 2 2v12c0 1-1 2-2 2H2c-1 0-2-1-2-2V2zm4
              8h4v2H4v-2z " />
                                        </svg>
                                        {{__('Payment Method')}}
                                    </a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab">
                                        <svg class="icon-20 " xmlns="http://www.w3.org/2000/svg " viewBox="0 0 20 20 ">
                                            <path d="M4 2h16l-3 9H4c-.6 0-1 .4-1 1s.5 1 1 1h13v2H4c-1.7 0-3-1.3-3-3s1.3-3 3-3h.3L3 5 2 2H0V0h3c.5 0
              1 .5 1 1v1zm1 18c-1 0-2-1-2-2s1-2 2-2 2 1 2 2-1 2-2 2zm10 0c-1 0-2-1-2-2s1-2 2-2 2 1 2 2-1 2-2 2z " />
                                        </svg>
                                        {{__('Invoices')}}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </aside>
                @endif
            </div>

            <!-- Tab cards -->
            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Owner Information -->
                    @if (Auth::user()->ownsTeam($team))
                        <div role="tabcard" class="tab-pane active" id="owner">
                            @include('spark::settings.teams.team-profile')
                        </div>
                    @endif

                    <!-- Membership -->
                    @if (Auth::user()->ownsTeam($team))
                    <div role="tabcard" class="tab-pane" id="membership">
                    @else
                    <div role="tabcard" class="tab-pane active" id="membership">
                    @endif
                        <div v-if="team">
                            @include('spark::settings.teams.team-membership')
                        </div>
                    </div>

                    <!-- Billing Tab Panes -->
                    @if (Spark::canBillTeams() && Auth::user()->ownsTeam($team))
                        @if (Spark::hasPaidTeamPlans())
                            <!-- Subscription -->
                            <div role="tabcard" class="tab-pane" id="subscription">
                                <div v-if="user && team">
                                    @include('spark::settings.subscription')
                                </div>
                            </div>
                        @endif

                        <!-- Payment Method -->
                        <div role="tabcard" class="tab-pane" id="payment-method">
                            <div v-if="user && team">
                                @include('spark::settings.payment-method')
                            </div>
                        </div>

                        <!-- Invoices -->
                        <div role="tabcard" class="tab-pane" id="invoices">
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
