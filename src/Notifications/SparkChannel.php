<?php

namespace Laravel\Spark\Notifications;

use RuntimeException;
use Laravel\Spark\Team;
use Illuminate\Notifications\Notification;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class SparkChannel
{
    /**
     * The notifications repository implementation.
     *
     * @var NotificationRepository
     */
    private $notifications;

    /**
     * Create a new spark channel instance.
     *
     * @param  NotificationRepository  $notifications
     * @return void
     */
    public function __construct(NotificationRepository $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $users = $notifiable instanceof Team ? $notifiable->users : [$notifiable];

        $data = $this->getData($notifiable, $notification);

        foreach ($users as $user) {
            $this->notifications->create($user, $data);
        }
    }

    /**
     * Get the data for the notification.
     *
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     * @return array
     *
     * @throws RuntimeException
     */
    protected function getData($notifiable, Notification $notification)
    {
        $message = $notification->toSpark($notifiable);

        return [
            'icon' => $message->icon,
            'body' => $message->body,
            'from' => $message->from,
            'action_text' => $message->actionText,
            'action_url' => $message->actionUrl,
        ];
    }
}