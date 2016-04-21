<?php

namespace Laravel\Spark\Interactions;

use Laravel\Spark\Contracts\Interactions\CheckPlanEligibility as Contract;

class CheckPlanEligibility implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function handle($user, $plan)
    {
        return true;
    }
}
