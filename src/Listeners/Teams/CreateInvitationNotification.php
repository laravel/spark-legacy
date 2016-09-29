<?php

namespace Laravel\Spark\Listeners\Teams;

use Laravel\Spark\Spark;
use Laravel\Spark\Events\Teams\UserInvitedToTeam;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class CreateInvitationNotification
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
     * @param  UserInvitedToTeam  $event
     * @return void
     */
    public function handle(UserInvitedToTeam $event)
    {
        $this->notifications->create($event->user, [
            'icon' => 'fa-users',
            'body' => 'You have been invited to join the '.$event->team->name.' team!',
            'action_text' => 'View Invitations',
            'action_url' => '/settings#/'.str_plural(Spark::teamString()),
        ]);
    }
}
