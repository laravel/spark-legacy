<?php

namespace Laravel\Spark\Configuration;

trait ManagesAppOptions
{
    /**
     * Where to redirect users after authentication.
     *
     * @var string
     */
    public static $afterLoginRedirectTo = '/home';

    /**
     * Indicates if we should show the team switcher.
     *
     * @var bool
     */
    public static $showTeamSwitcher = true;

    /**
     * Where to redirect users after authentication.
     *
     * @return string
     */
    public static function afterLoginRedirect()
    {
        return static::$afterLoginRedirectTo;
    }

    /**
     * Set the path to redirect to after authentication.
     *
     * @return void
     */
    public static function afterLoginRedirectTo($path)
    {
        static::$afterLoginRedirectTo = $path;
    }

    /**
     * Determine if teams are identified by path.
     *
     * @return bool
     */
    public static function teamsIdentifiedByPath()
    {
        return ! static::showsTeamSwitcher();
    }

    /**
     * Indicate that teams will be identified by path, not by "switching".
     *
     * @return static
     */
    public static function identifyTeamsByPath()
    {
        return static::hideTeamSwitcher();
    }

    /**
     * Determine if the application should show the team switcher.
     *
     * @return bool
     */
    public static function showsTeamSwitcher()
    {
        return static::$showTeamSwitcher;
    }

    /**
     * Hides the team switcher from the navigation menu.
     *
     * @return void
     */
    public static function hideTeamSwitcher()
    {
        static::$showTeamSwitcher = false;

        return new static;
    }
}
