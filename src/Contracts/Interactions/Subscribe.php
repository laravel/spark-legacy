<?php

namespace Laravel\Spark\Contracts\Interactions;

interface Subscribe
{
    /**
     * Subscribe the user to a subscription plan.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Laravel\Spark\Plan  $plan
     * @param  bool  $fromRegistration
     * @param  array  $data
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function handle($user, $plan, $fromRegistration, array $data);
}
