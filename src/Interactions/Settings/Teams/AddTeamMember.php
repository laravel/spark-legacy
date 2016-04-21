<?php

namespace Laravel\Spark\Interactions\Settings\Teams;

use Laravel\Spark\Spark;
use Laravel\Spark\Events\Teams\TeamMemberAdded;
use Laravel\Spark\Contracts\Interactions\Settings\Teams\AddTeamMember as Contract;

class AddTeamMember implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function handle($team, $user, $role = null)
    {
        $team->users()->attach($user, ['role' => $role ?: Spark::defaultRole()]);

        event(new TeamMemberAdded($team, $user));
    }
}
