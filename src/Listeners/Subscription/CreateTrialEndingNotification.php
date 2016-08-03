<?php

namespace Laravel\Spark\Listeners\Subscription;

use Laravel\Spark\Spark;
use Laravel\Spark\Events\Auth\UserRegistered;
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        if (! Spark::trialDays() || ! $event->user->trial_ends_at) {
            return;
        }

        $this->notifications->create($event->user, [
            'icon' => 'fa-clock-o',
            'body' => 'Your trial period will expire on '.$event->user->trial_ends_at->format('F jS').'.',
            'action_text' => 'Subscribe',
            'action_url' => '/settings#/subscription',
        ]);
    }
}
