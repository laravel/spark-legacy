<?php

namespace Laravel\Spark\Contracts\Interactions;

interface CheckTeamPlanEligibility
{
    /**
     * Determine if the team is eligible to switch to the given plan.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    public function handle($team, $plan);
}
