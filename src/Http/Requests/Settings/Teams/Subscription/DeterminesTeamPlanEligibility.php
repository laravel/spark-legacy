<?php

namespace Laravel\Spark\Http\Requests\Settings\Teams\Subscription;

use Laravel\Spark\Spark;
use Laravel\Spark\Exceptions\IneligibleForPlan;

trait DeterminesTeamPlanEligibility
{
    /**
     * Validate that the plan is eligible based on team restrictions.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function validatePlanEligibility($validator)
    {
        $plan = Spark::teamPlans()->where('id', $this->plan)->first();

        // If the desired plan is free, we will always need to let the user switch to that
        // plan since we'll want the user to always be able to cancel this subscription
        // without preventing them. So, we will just return here if it's a free plan.
        if (! $plan || $plan->price === 0) {
            return;
        }

        $this->callCustomCallback($validator, $plan);

        // If the user is ineligible for a plan based on their team member or collaborator
        // count, we will prevent them switching to this plan and send an error message
        // back to the client informing them of this limitation and they can upgrade.
        if (! $this->teamIsEligibleForPlan($this->route('team'), $plan)) {
            $validator->errors()->add(
                'plan', 'This team has too many team members for the selected plan.'
            );
        }
    }

    /**
     * Determine if the team is eligible to move to a given plan.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    protected function teamIsEligibleForPlan($team, $plan)
    {
        return ! $this->exceedsMaximumTeamMembers($team, $plan);
    }

    /**
     * Determine if the team exceeds the maximum team members for the plan.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    protected function exceedsMaximumTeamMembers($team, $plan)
    {
        return ! is_null($plan->teamMembers)
                    ? $plan->teamMembers < $team->totalPotentialUsers() : false;
    }

    /**
     * Call the custom plan eligibility checker callback.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @param  \Laravel\Spark\Plan  $plan
     * @return void
     */
    protected function callCustomCallback($validator, $plan)
    {
        try {
            if (! Spark::eligibleForTeamPlan($this->route('team'), $plan)) {
                $validator->errors()->add('plan', 'This team is not eligible for this plan.');
            }
        } catch (IneligibleForPlan $e) {
            $validator->errors()->add('plan', $e->getMessage());
        }
    }
}
