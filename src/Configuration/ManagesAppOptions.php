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
     * Indicates that users can create additional teams from the dashboard.
     *
     * @var bool
     */
    public static $createsAdditionalTeams = true;

    /**
     * The prefix used in the URI to describe teams.
     *
     * @var string
     */
    public static $teamsPrefix = 'teams';

    /**
     * Minimum length a user given password can be.
     *
     * @var string
     */
    public static $minimumPasswordLength = 6;

    /**
     * Indicates that the application should use the right-to-left theme.
     *
     * @var bool
     */
    public static $usesRightToLeftTheme = false;

    /**
     * Where to redirect users after authentication.
     *
     * @return string
     */
    public static function afterLoginRedirect()
    {
        return value(static::$afterLoginRedirectTo);
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
     * @return static
     */
    public static function hideTeamSwitcher()
    {
        static::$showTeamSwitcher = false;

        return new static;
    }

    /**
     * Determines if users can create additional teams from dashboard.
     *
     * @return bool
     */
    public static function createsAdditionalTeams()
    {
        return static::$createsAdditionalTeams;
    }

    /**
     * Specifies that users cannot create additional teams from dashboard.
     *
     * @return static
     */
    public static function noAdditionalTeams()
    {
        static::$createsAdditionalTeams = false;

        return new static;
    }

    /**
     * Get the string used to describe teams.
     *
     * @return string
     */
    public static function teamsPrefix()
    {
        return static::$teamsPrefix;
    }

    /**
     * Set the string used to describe teams.
     *
     * @param  string  $string
     * @return void
     */
    public static function prefixTeamsAs($string)
    {
        static::$teamsPrefix = $string;
    }

    /**
     * Get or set the minimum length a user given password can be.
     *
     * @param  string|null  $length
     * @return string
     */
    public static function minimumPasswordLength($length = null)
    {
        if (is_null($length)) {
            return static::$minimumPasswordLength;
        } else {
            static::$minimumPasswordLength = $length;

            return new static;
        }
    }

    /**
     * Determine if the application should use the right-to-left theme.
     *
     * @return bool
     */
    public static function usesRightToLeftTheme()
    {
        return static::$usesRightToLeftTheme;
    }

    /**
     * Indication that the application should use the right-to-left theme.
     *
     * @return void
     */
    public static function useRightToLeftTheme()
    {
        static::$usesRightToLeftTheme = true;
    }
}
