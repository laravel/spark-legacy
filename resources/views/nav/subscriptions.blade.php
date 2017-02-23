@if (Auth::user()->onTrial())
    <!-- Trial Reminder -->
    <li class="dropdown-header">Trial</li>

    <li>
        @if (Spark::createsAdditionalTeams())
            <a href="/settings#/subscription">
                <i class="fa fa-fw fa-btn fa-shopping-bag"></i>Subscribe
            </a>
        @else
            <a href="/settings/{{str_plural(Spark::teamString())}}/{{ Auth::user()->current_team_id }}#/subscription" aria-controls="teams">
                <i class="fa fa-fw fa-btn fa-shopping-bag"></i>Subscribe
            </a>
        @endif
    </li>

    <li class="divider"></li>
@endif

@if (Spark::usesTeams() && Auth::user()->currentTeamOnTrial())
    <!-- Team Trial Reminder -->
    <li class="dropdown-header">{{ ucfirst(Spark::teamString()) }} Trial</li>

    <li>
        <a href="/settings/{{ str_plural(Spark::teamString()) }}/{{ Auth::user()->currentTeam()->id }}#/subscription">
            <i class="fa fa-fw fa-btn fa-shopping-bag"></i>Subscribe
        </a>
    </li>

    <li class="divider"></li>
@endif
