<?php

namespace Laravel\Spark\Events;

class AnnouncementCreated
{
    /**
     * The announcement instance.
     *
     * @var \Laravel\Spark\Announcement
     */
    public $announcement;

    /**
     * Create a new announcement instance.
     *
     * @param  \Laravel\Spark\Announcement  $announcement
     * @return void
     */
    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }
}
