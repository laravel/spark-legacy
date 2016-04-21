<?php

namespace Laravel\Spark\Interactions\Settings\Teams;

use Laravel\Spark\Spark;
use Illuminate\Support\Facades\Validator;
use Laravel\Spark\Contracts\Interactions\Settings\Teams\UpdateTeamMember as Contract;

class UpdateTeamMember implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function validator($team, $member, array $data)
    {
        return Validator::make($data, [
            'role' => 'required|in:'.implode(',', array_keys(Spark::roles())),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function handle($team, $member, array $data)
    {
        $team->users()->updateExistingPivot($member->id, [
            'role' => $data['role']
        ]);
    }
}
