<?php

namespace Laravel\Spark\Contracts\Interactions\Settings\Teams;

interface UpdateTeamPhoto
{
    /**
     * Get a validator instance for the given data.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  array  $data
     * @return \Illuminate\Validation\Validator
     */
    public function validator($team, array $data);

    /**
     * Update the teams's photo.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  array  $data
     * @return \Laravel\Spark\Team
     */
    public function handle($team, array $data);
}
