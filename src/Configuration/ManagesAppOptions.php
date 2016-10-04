<?php

namespace Laravel\Spark\Configuration;

trait ManagesAppOptions
{
    /**
     * Indicates that users must create teams on registration.
     *
     * @var bool
     */
    public static $requireTeamOnRegistration = true;

    /**
     * Determines if users can have to create a team on registration.
     *
     * @return bool
     */
    public static function teamOnRegistration()
    {
        if (! static::usesTeams()) {
            return false;
        }

        return static::$requireTeamOnRegistration ||
               (static::needsCardUpFront() && static::plans()->isEmpty());
    }

    /**
     * Indicate that no team is required on registration.
     *
     * @return void
     */
    public static function noTeamOnRegistration()
    {
        static::$requireTeamOnRegistration = false;
    }
}
