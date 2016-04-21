<?php

namespace Laravel\Spark\Events\Kiosk;

use Laravel\Spark\Announcement;

class AnnouncementCreated
{
    /**
     * The announcement instance.
     *
     * @var Announcement
     */
    public $announcement;

    /**
     * Create a new event instance.
     *
     * @param  Announcement  $announcement
     * @return void
     */
    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }
}
