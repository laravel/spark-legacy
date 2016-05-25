<?php

namespace Laravel\Spark\Listeners\Subscription;

use Laravel\Spark\Spark;
use Laravel\Spark\Events\Subscription\UserSubscribed;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class RemoveTrialEndingNotification
{
    /**
     * Handle the event.
     *
     * @param  UserSubscribed  $event
     * @return void
     */
    public function handle(UserSubscribed $event)
    {
        if (! Spark::trialDays()) {
            return;
        }

        $notification = Notification::where('user_id', $event->user->id)
                      ->where('event', 'UserRegistered')
                      ->first()
                      ->delete();
    }
}
