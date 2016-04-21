<?php

namespace Laravel\Spark\Contracts\Interactions;

interface CheckPlanEligibility
{
    /**
     * Determine if the user is eligible to switch to the given plan.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    public function handle($user, $plan);
}
