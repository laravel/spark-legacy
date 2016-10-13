<?php

namespace Laravel\Spark\Configuration;

trait ManagesAppOptions
{
    /**
     * Indicates that a users may not have teams.
     *
     * @var bool
     */
    public static $optionalTeams = false;

    /**
     * Determines if users may not have any teams.
     *
     * @return bool
     */
    public static function optionalTeams()
    {
        return ! static::usesTeams() || static::$optionalTeams;
    }

    /**
     * Indicate that having a team is optional.
     *
     * @return void
     */
    public static function makeTeamsOptional()
    {
        static::$optionalTeams = true;
    }
}
