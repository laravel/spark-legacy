<?php

namespace Laravel\Spark\Http\Requests\Settings\Teams;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->ownsTeam($this->team);
    }

    /**
     * Get the validator for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator()
    {
        $validator = Validator::make($this->all(), [
            'email' => 'required|email|max:255',
        ]);

        $validator->after(function ($validator) {
            $this->validateMaxTeamMembersNotExceeded($validator);
        });

        return $validator->after(function ($validator) {
            return $this->verifyEmailNotAlreadyOnTeam($validator, $this->team)
                        ->verifyEmailNotAlreadyInvited($validator, $this->team);
        });
    }

    /**
     * Verify that the maximum number of team members hasn't been exceeded.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function validateMaxTeamMembersNotExceeded($validator)
    {
        if ($plan = $this->user()->sparkPlan()) {
            $this->validateMaxTeamMembersNotExceededForPlan($validator, $plan);
        }

        if ($plan = $this->team->sparkPlan()) {
            $this->validateMaxTeamMembersNotExceededForPlan($validator, $plan);
        }
    }

    /**
     * Verify the team member limit hasn't been exceeded for the given plan.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @param  \Laravel\Spark\Plan  $plan
     * @return void
     */
    protected function validateMaxTeamMembersNotExceededForPlan($validator, $plan)
    {
        if (is_null($plan->teamMembers) && is_null($plan->collaborators)) {
            return;
        }

        if ($this->exceedsMaxTeamMembers($plan) || $this->exceedsMaxCollaborators($plan)) {
            $validator->errors()->add('email', 'Please upgrade your subscription to add more team members.');
        }
    }

    /**
     * Determine if the request will exceed the max allowed team members.
     *
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    protected function exceedsMaxTeamMembers($plan)
    {
        return ! is_null($plan->teamMembers) &&
               $plan->teamMembers <= $this->team->totalPotentialUsers();
    }

    /**
     * Determine if the request will exceed the max allowed collaborators.
     *
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    protected function exceedsMaxCollaborators($plan)
    {
        return ! is_null($plan->collaborators) &&
               $plan->collaborators <= $this->user()->totalPotentialCollaborators();
    }

    /**
     * Verify that the given e-mail is not already on the team.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @param  \Laravel\Spark\Team  $team
     * @return $this
     */
    protected function verifyEmailNotAlreadyOnTeam($validator, $team)
    {
        if ($team->users()->where('email', $this->email)->exists()) {
            $validator->errors()->add('email', 'That user is already on the team.');
        }

        return $this;
    }

    /**
     * Verify that the given e-mail is not already invited.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @param  \Laravel\Spark\Team  $team
     * @return $this
     */
    protected function verifyEmailNotAlreadyInvited($validator, $team)
    {
        if ($team->invitations()->where('email', $this->email)->exists()) {
            $validator->errors()->add('email', 'That user is already invited to the team.');
        }

        return $this;
    }
}
