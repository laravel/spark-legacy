<?php

namespace Laravel\Spark\Http\Requests\Settings\Teams;

use Illuminate\Foundation\Http\FormRequest;

class RemoveTeamMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $team = $this->route('team');

        $member = $this->route('team_member');

        return ($this->user()->ownsTeam($team) && $this->user()->id !== $member->id) ||
               (! $this->user()->ownsTeam($team) && $this->user()->id === $member->id);
    }

    /**
     * Get the validation rules for the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
