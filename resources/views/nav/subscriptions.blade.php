@if (Auth::user()->onTrial())
    <!-- Trial Reminder -->
    <h6 class="dropdown-header">{{__('Trial')}}</h6>

    <a class="dropdown-item" href="/settings#/subscription">
        <i class="fa fa-fw text-left fa-btn fa-shopping-bag"></i> {{__('Subscribe')}}
    </a>

    <div class="dropdown-divider"></div>
@endif

@if (Spark::usesTeams() && Auth::user()->currentTeamOnTrial())
    <!-- Team Trial Reminder -->
    <h6 class="dropdown-header">{{__('Trial')}}</h6>

    <a class="dropdown-item" href="/settings/{{ Spark::teamsPrefix() }}/{{ Auth::user()->currentTeam()->id }}#/subscription">
        <i class="fa fa-fw text-left fa-btn fa-shopping-bag"></i> {{__('Subscribe')}}
    </a>

    <div class="dropdown-divider"></div>
@endif
