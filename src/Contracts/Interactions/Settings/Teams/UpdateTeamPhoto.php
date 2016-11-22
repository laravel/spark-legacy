<?php

namespace Laravel\Spark\Contracts\Interactions\Settings\Teams;

interface UpdateTeamPhoto
{
    /**
     * Get a validator instance for the given data.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $data
     * @return \Illuminate\Validation\Validator
     */
    public function validator($user, array $data);

    /**
     * Update the user's profile photo.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  array  $data
     * @return \Laravel\Spark\Team
     */
    public function handle($team, array $data);
}
