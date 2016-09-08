<?php

namespace Laravel\Spark\Contracts\Interactions\Settings\Teams;

interface SendInvitation
{
    /**
     * Create and mail an invitation to the given e-mail address.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  string  $email
     * @return \Laravel\Spark\Invitation
     */
    public function handle($team, $email);
}
