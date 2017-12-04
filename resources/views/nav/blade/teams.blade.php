<li class="divider"></li>

<!-- Teams -->
<li class="dropdown-header">{{ __('teams.teams') }}</li>

<!-- Create Team -->
@if (Spark::createsAdditionalTeams())
    <li>
        <a href="/settings#/{{ Spark::teamsPrefix() }}">
            <i class="fa fa-fw text-left fa-btn fa-plus"></i> {{__('teams.create_team')}}
        </a>
    </li>
@endif

<!-- Switch Current Team -->
@if (Spark::showsTeamSwitcher())
    @foreach (Auth::user()->teams as $team)
        <li>
            <a href="/settings/{{ Spark::teamsPrefix() }}/{{ $team->id }}/switch">
                @if (Auth::user()->current_team_id === $team->id)
                    <i class="fa fa-fw text-left fa-btn fa-check text-success"></i> {{ $team->name }}
                @else
                    <img src="{{ $team->photo_url }}" class="spark-profile-photo-xs"><i class="fa fa-btn"></i> {{ $team->name }}
                @endif
            </a>
        </li>
    @endforeach
@endif
