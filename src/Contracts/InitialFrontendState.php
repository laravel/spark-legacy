<?php

namespace Laravel\Spark\Contracts;

interface InitialFrontendState
{
    /**
     * Generate the initial front-end state for the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return array
     */
    public function forUser($user);
}
