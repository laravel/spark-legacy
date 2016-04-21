<li class="divider"></li>

<!-- Teams -->
<li class="dropdown-header">Teams</li>

<!-- Create Team -->
<li>
    <a href="/settings#/teams">
        <i class="fa fa-fw fa-btn fa-plus"></i>Create Team
    </a>
</li>

<!-- Switch Current Team -->
@foreach (Auth::user()->teams as $team)
    <li>
        <a href="/teams/{{ $team->id }}/switch">
            @if (Auth::user()->current_team_id === $team->id)
                <i class="fa fa-fw fa-btn fa-check text-success"></i>{{ $team->name }}
            @else
                <img src="{{ $team->photo_url }}" class="spark-team-photo-xs"><i class="fa fa-btn"></i>{{ $team->name }}
            @endif
        </a>
    </li>
@endforeach
