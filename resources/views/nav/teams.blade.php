<!-- Teams -->
<li class="dropdown-header">{{ ucfirst(str_plural(Spark::teamString())) }}</li>

<!-- Create Team -->
@if (Spark::createsAdditionalTeams())
    <li>
        <a href="/settings#/{{str_plural(Spark::teamString())}}">
            <i class="fa fa-fw fa-btn fa-plus"></i>Create {{ ucfirst(Spark::teamString()) }}
        </a>
    </li>
@endif

<!-- Switch Current Team -->
@if (Spark::showsTeamSwitcher())
    <li v-for="team in teams">
        <a :href="'/{{ str_plural(Spark::teamString()) }}/'+ team.id +'/switch'">
            <span v-if="user.current_team_id == team.id">
                <i class="fa fa-fw fa-btn fa-check text-success"></i>@{{ team.name }}
            </span>

            <span v-else>
                <img :src="team.photo_url" class="spark-team-photo-xs"><i class="fa fa-btn"></i>@{{ team.name }}
            </span>
        </a>
    </li>
@endif

<li class="divider"></li>
