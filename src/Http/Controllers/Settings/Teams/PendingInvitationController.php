<?php

namespace Laravel\Spark\Http\Controllers\Settings\Teams;

use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Laravel\Spark\Invitation;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Contracts\Interactions\Settings\Teams\AddTeamMember;

class PendingInvitationController extends Controller
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
     * Get all of the pending invitations for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function all(Request $request)
    {
        return $request->user()->invitations()->with('team')->get();
    }

    /**
     * Accept the given invitations.
     *
     * @param  Request  $request
     * @param  \Laravel\Spark\Invitation  $invitation
     * @return Response
     */
    public function accept(Request $request, Invitation $invitation)
    {
        abort_unless($request->user()->id == $invitation->user_id, 404);

        Spark::interact(AddTeamMember::class, [
            $invitation->team, $request->user()
        ]);

        $invitation->delete();
    }

    /**
     * Reject the given invitations.
     *
     * @param  Request  $request
     * @param  \Laravel\Spark\Invitation  $invitation
     * @return Response
     */
    public function reject(Request $request, Invitation $invitation)
    {
        abort_unless($request->user()->id == $invitation->user_id, 404);

        $invitation->delete();
    }
}
