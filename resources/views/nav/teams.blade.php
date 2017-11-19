<!-- Teams -->
<h6 class="dropdown-header">{{ ucfirst(str_plural(Spark::teamString())) }}</h6>

<!-- Create Team -->
@if (Spark::createsAdditionalTeams())
    <a class="dropdown-item" href="/settings#/{{str_plural(Spark::teamString())}}">
        <i class="fa fa-fw fa-btn fa-plus-circle"></i> Create {{ ucfirst(Spark::teamString()) }}
    </a>
@endif

<!-- Switch Current Team -->
@if (Spark::showsTeamSwitcher())
    <a class="dropdown-item" v-for="team in teams" :href="'/{{ str_plural(Spark::teamString()) }}/'+ team.id +'/switch'">
        <span v-if="user.current_team_id == team.id">
            <i class="fa fa-fw fa-btn fa-check text-success"></i> @{{ team.name }}
        </span>

        <span v-else>
            <img :src="team.photo_url" class="spark-profile-photo-xs"><i class="fa fa-btn"></i> @{{ team.name }}
        </span>
    </a>
@endif

<div class="dropdown-divider"></div>
