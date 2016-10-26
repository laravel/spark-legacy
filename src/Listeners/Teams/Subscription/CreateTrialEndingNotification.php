<?php

namespace Laravel\Spark\Listeners\Teams\Subscription;

use Laravel\Spark\Spark;
use Laravel\Spark\Events\Teams\TeamCreated;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class CreateTrialEndingNotification
{
    /**
     * The notification repository instance.
     *
     * @var NotificationRepository
     */
    protected $notifications;

    /**
     * Create a new listener instance.
     *
     * @param  NotificationRepository  $notifications
     * @return void
     */
    public function __construct(NotificationRepository $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * Handle the event.
     *
     * @param  TeamCreated  $event
     * @return void
     */
    public function handle(TeamCreated $event)
    {
        if (! Spark::teamTrialDays()) {
            return;
        }

        $this->notifications->create($event->team->owner, [
            'icon' => 'fa-clock-o',
            'body' => "The ".$event->team->name." ".Spark::teamString()."'s trial period will expire on ".$event->team->trial_ends_at->format('F jS').'.',
            'action_text' => 'Subscribe',
            'action_url' => '/settings/'.str_plural(Spark::teamString()).'/'.$event->team->id.'#/subscription',
        ]);
    }
}
