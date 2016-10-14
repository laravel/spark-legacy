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
    }
}
