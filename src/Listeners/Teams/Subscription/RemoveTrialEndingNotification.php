<?php

namespace Laravel\Spark\Listeners\Teams\Subscription;

use Laravel\Spark\Spark;
use Laravel\Spark\Events\Teams\Subscription\TeamSubscribed;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class RemoveTrialEndingNotification
{
    /**
     * Handle the event.
     *
     * @param  TeamSubscribed  $event
     * @return void
     */
    public function handle(TeamSubscribed $event)
    {
        if (! Spark::teamTrialDays()) {
            return;
        }

        $notification = Notification::where('user_id', $event->team->owner->id)
                      ->where('event', 'TeamRegistered')
                      ->first()
                      ->delete();
    }
}
