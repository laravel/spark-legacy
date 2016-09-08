<?php

namespace Laravel\Spark\Repositories;

use Ramsey\Uuid\Uuid;
use Laravel\Spark\Notification;
use Laravel\Spark\Events\NotificationCreated;
use Laravel\Spark\Contracts\Repositories\NotificationRepository as NotificationRepositoryContract;

class NotificationRepository implements NotificationRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function recent($user)
    {
        // Retrieve all unread notifications for the user...
        $unreadNotifications = Notification::with('creator')
                                    ->where('user_id', $user->id)
                                    ->where('read', 0)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        // Retrieve the 8 most recent read notifications for the user...
        $readNotifications = Notification::with('creator')
                                    ->where('user_id', $user->id)
                                    ->where('read', 1)
                                    ->orderBy('created_at', 'desc')
                                    ->take(8)
                                    ->get();

        // Add the read notifications to the unread notifications so they show afterwards...
        $notifications = $unreadNotifications->merge($readNotifications)->sortByDesc('created_at');

        if (count($notifications) > 0) {
            Notification::whereNotIn('id', $notifications->pluck('id'))
                        ->where('user_id', $user->id)
                        ->where('created_at', '<', $notifications->first()->created_at)
                        ->delete();
        }

        return $notifications->values();
    }

    /**
     * {@inheritdoc}
     */
    public function create($user, array $data)
    {
        $creator = array_get($data, 'from');

        $notification = Notification::create([
            'id' => Uuid::uuid4(),
            'user_id' => $user->id,
            'created_by' => $creator ? $creator->id : null,
            'icon' => $data['icon'],
            'body' => $data['body'],
            'action_text' => array_get($data, 'action_text'),
            'action_url' => array_get($data, 'action_url'),
        ]);

        event(new NotificationCreated($notification));

        return $notification;
    }

    /**
     * {@inheritdoc}
     */
    public function personal($user, $from, array $data)
    {
        return $this->create($user, array_merge($data, ['from' => $from]));
    }
}
