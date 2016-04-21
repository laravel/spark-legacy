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
<li v-for="team in teams">
    <a href="/teams/@{{ team.id }}/switch">
        <span v-if="user.current_team_id == team.id">
            <i class="fa fa-fw fa-btn fa-check text-success"></i>@{{ team.name }}
        </span>

        <span v-else>
            <img :src="team.photo_url" class="spark-team-photo-xs"><i class="fa fa-btn"></i>@{{ team.name }}
        </span>
    </a>
</li>
