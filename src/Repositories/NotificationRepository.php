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
        $notifications = Notification::with('creator')->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')->take(8)->get();

        if (count($notifications) > 0) {
            Notification::whereNotIn('id', $notifications->lists('id'))
                        ->where('user_id', $user->id)
                        ->where('created_at', '<', $notifications->first()->created_at)
                        ->delete();
        }

        return $notifications;
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
