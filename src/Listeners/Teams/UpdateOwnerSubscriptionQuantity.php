<?php

namespace Laravel\Spark\Listeners\Teams;

use Laravel\Spark\Spark;
use Laravel\Spark\Events\Teams\TeamCreated;

class UpdateOwnerSubscriptionQuantity
{
    /**
     * Handle the event.
     *
     * @param  mixed $event
     * @return void
     */
    public function handle($event)
    {
        if (! Spark::chargesUsersPerTeam()) {
            return;
        }

        if ($event instanceof TeamCreated) {
            $this->incrementQuantity($event->team->owner);
        } else {
            $this->decrementQuantity($event->team->owner);
        }
    }


    /**
     * Increment the subscription quantity.
     *
     * @param  mixed  $owner
     * @return void
     */
    private function incrementQuantity($owner)
    {
        if ($owner->ownedTeams()->count() > 1) {
            $owner->addSeat();
        }
    }

    /**
     * Decrement the subscription quantity.
     *
     * @param  mixed  $owner
     * @return void
     */
    private function decrementQuantity($owner)
    {
        if ($owner->subscription()->quantity > 1) {
            $owner->removeSeat();
        }
    }
}
