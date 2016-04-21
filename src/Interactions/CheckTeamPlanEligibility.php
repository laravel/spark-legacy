<?php

namespace Laravel\Spark\Interactions;

use Laravel\Spark\Contracts\Interactions\CheckTeamPlanEligibility as Contract;

class CheckTeamPlanEligibility implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function handle($team, $plan)
    {
        return true;
    }
}
