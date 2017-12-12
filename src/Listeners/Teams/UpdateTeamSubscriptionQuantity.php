<?php

namespace Laravel\Spark\Listeners\Teams;

use Laravel\Spark\Spark;
use Laravel\Spark\Events\Teams\TeamMemberAdded;

class UpdateTeamSubscriptionQuantity
{
    /**
     * Handle the event.
     *
     * @param  mixed $event
     * @return void
     */
    public function handle($event)
    {
        if (! Spark::chargesTeamsPerMember()) {
            return;
        }

        if ($event instanceof TeamMemberAdded) {
            $this->incrementQuantity($event->team);
        } else {
            $this->decrementQuantity($event->team);
        }
    }


    /**
     * Increment the subscription quantity.
     *
     * @param  \Laravel\Spark\Team  $team
     * @return void
     */
    private function incrementQuantity($team)
    {
        if ($team->users()->count() > 1) {
            $team->addSeat();
        }
    }

    /**
     * Decrement the subscription quantity.
     *
     * @param  \Laravel\Spark\Team  $team
     * @return void
     */
    private function decrementQuantity($team)
    {
        if ($team->subscription()->quantity > 1) {
            $team->removeSeat();
        }
    }
}
