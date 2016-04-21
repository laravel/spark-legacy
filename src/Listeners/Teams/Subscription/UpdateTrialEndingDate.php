<?php

namespace Laravel\Spark\Listeners\Teams\Subscription;

class UpdateTrialEndingDate
{
    /**
     * Handle the event.
     *
     * @param  mixed  $event
     * @return void
     */
    public function handle($event)
    {
        $event->team->forceFill([
            'trial_ends_at' => $event->team->subscription()->trial_ends_at,
        ])->save();
    }
}
