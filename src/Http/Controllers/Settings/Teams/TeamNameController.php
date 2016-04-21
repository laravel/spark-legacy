<?php

namespace Laravel\Spark\Http\Controllers\Settings\Teams;

use Illuminate\Http\Request;
use Laravel\Spark\Http\Controllers\Controller;

class TeamNameController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the given team's name.
     *
     * @param  Request  $request
     * @param  \Laravel\Spark\Team  $team
     * @return Response
     */
    public function update(Request $request, $team)
    {
        abort_unless($request->user()->ownsTeam($team), 404);

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $team->forceFill([
            'name' => $request->name,
        ])->save();
    }
}
