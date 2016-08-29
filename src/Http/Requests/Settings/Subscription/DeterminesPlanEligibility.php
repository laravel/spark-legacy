<?php

namespace Laravel\Spark\Http\Requests\Settings\Subscription;

use Laravel\Spark\Spark;
use Laravel\Spark\Exceptions\IneligibleForPlan;

trait DeterminesPlanEligibility
{
    /**
     * Validate that the plan is eligible based on team restrictions.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function validatePlanEligibility($validator)
    {
        $plan = Spark::plans()->where('id', $this->plan)->first();

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
        if (! $this->userIsEligibleForPlan($plan)) {
            $validator->errors()->add(
                'plan', trans('spark::validation.eligibility')
            );
        }
    }

    /**
     * Determine if the user is eligible to move to a given plan.
     *
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    protected function userIsEligibleForPlan($plan)
    {
        return ! $this->exceedsMaximumTeams($plan) &&
               ! $this->exceedsMaximumTeamMembers($plan) &&
               ! $this->exceedsMaximumCollaborators($plan);
    }

    /**
     * Determine if the user exceeds the maximum teams.
     *
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    protected function exceedsMaximumTeams($plan)
    {
        if (is_null($plan->teams)) {
            return false;
        }

        return $plan->teams < $this->user()->ownedTeams()->count();
    }

    /**
     * Determine if the user exceeds the maximum team members for the plan.
     *
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    protected function exceedsMaximumTeamMembers($plan)
    {
        if (is_null($plan->teamMembers)) {
            return false;
        }

        return ! is_null($this->user()->teams->first(function ($team) use ($plan) {
            return $plan->teamMembers < $team->totalPotentialUsers();
        }));
    }

    /**
     * Determine if the user exceeds the maximum total collaborators for the plan.
     *
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    protected function exceedsMaximumCollaborators($plan)
    {
        return ! is_null($plan->collaborators) &&
            $plan->collaborators < $this->user()->totalPotentialCollaborators();
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
            if (! Spark::eligibleForPlan($this->user(), $plan)) {
                $validator->errors()->add('plan', 'You are not eligible for this plan.');
            }
        } catch (IneligibleForPlan $e) {
            $validator->errors()->add('plan', $e->getMessage());
        }
    }
}
