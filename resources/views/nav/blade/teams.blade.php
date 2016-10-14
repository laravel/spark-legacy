<li class="divider"></li>

<!-- Teams -->
<li class="dropdown-header">{{ ucfirst(str_plural(Spark::teamString())) }}</li>

<!-- Create Team -->
@if (Spark::createsAdditionalTeams())
    <li>
        <a href="/settings#/{{ str_plural(Spark::teamString()) }}">
            <i class="fa fa-fw fa-btn fa-plus"></i>Create {{ ucfirst(Spark::teamString()) }}
        </a>
    </li>
@endif

<!-- Switch Current Team -->
@if (Spark::showsTeamSwitcher())
    @foreach (Auth::user()->teams as $team)
        <li>
            <a href="/{{ str_plural(Spark::teamString()) }}/{{ $team->id }}/switch">
                @if (Auth::user()->current_team_id === $team->id)
                    <i class="fa fa-fw fa-btn fa-check text-success"></i>{{ $team->name }}
                @else
                    <img src="{{ $team->photo_url }}" class="spark-team-photo-xs"><i class="fa fa-btn"></i>{{ $team->name }}
                @endif
            </a>
        </li>
    @endforeach
@endif
