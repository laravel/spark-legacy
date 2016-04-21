<?php

namespace Laravel\Spark\Contracts\Interactions\Auth;

use Laravel\Spark\Contracts\Http\Requests\Auth\RegisterRequest;

interface Register
{
    /**
     * Register a new user with the application.
     *
     * @param  \Laravel\Spark\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function handle(RegisterRequest $request);
}
