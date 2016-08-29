<?php

namespace Laravel\Spark;

use Laravel\Spark\Contracts\Repositories\UserRepository;
use Laravel\Spark\Contracts\Repositories\TeamRepository;
use Laravel\Spark\Contracts\InitialFrontendState as Contract;

class InitialFrontendState implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function forUser($user)
    {
        return [
            'user' => $this->currentUser(),
            'teams' => $user ? $this->teams($user) : [],
            'currentTeam' => $user ? $this->currentTeam($user) : null,
        ];
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function currentUser()
    {
        return Spark::interact(UserRepository::class.'@current');
    }

    /**
     * Get all of the teams for the user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    protected function teams($user)
    {
        return Spark::usesTeams() ? Spark::interact(
            TeamRepository::class.'@forUser', [$user]
        ) : [];
    }

    /**
     * Get the current team for the user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return \Laravel\Spark\Team|null
     */
    protected function currentTeam($user)
    {
        if (Spark::usesTeams() && $user->currentTeam()) {
            return Spark::interact(
                TeamRepository::class.'@find', [$user->currentTeam()->id]
            );
        }
    }
}
