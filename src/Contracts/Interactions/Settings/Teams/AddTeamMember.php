<?php

namespace Laravel\Spark\Contracts\Interactions\Settings\Teams;

interface AddTeamMember
{
    /**
     * Add a user to the given team.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string|null  $role
     * @return \Laravel\Spark\Team
     */
    public function handle($team, $user, $role = null);
}
