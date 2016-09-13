<?php

namespace Laravel\Spark\Contracts\Interactions;

interface SubscribeTeam
{
    /**
     * Subscribe the team to a subscription plan.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  \Laravel\Spark\Plan  $plan
     * @param  array  $data
     * @return \Laravel\Spark\Team
     */
    public function handle($team, $plan, $fromRegistration, array $data);
}
