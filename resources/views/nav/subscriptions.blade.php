@if (Auth::user()->onTrial())
    <!-- Trial Reminder -->
    <h6 class="dropdown-header">Trial</h6>

    <a class="dropdown-item" href="/settings#/subscription">
        <i class="fa fa-fw fa-btn fa-shopping-bag"></i> Subscribe
    </a>

    <div class="dropdown-divider"></div>
@endif

@if (Spark::usesTeams() && Auth::user()->currentTeamOnTrial())
    <!-- Team Trial Reminder -->
    <h6 class="dropdown-header">{{ ucfirst(Spark::teamString()) }} Trial</h6>

    <a class="dropdown-item" href="/settings/{{ str_plural(Spark::teamString()) }}/{{ Auth::user()->currentTeam()->id }}#/subscription">
        <i class="fa fa-fw fa-btn fa-shopping-bag"></i> Subscribe
    </a>

    <div class="dropdown-divider"></div>
@endif
