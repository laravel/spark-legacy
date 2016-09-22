<?php

namespace Laravel\Spark\Configuration;

use Laravel\Spark\CanJoinTeams;

trait ManagesModelOptions
{
    /**
     * The user model class name.
     *
     * @var string
     */
    public static $userModel = 'App\User';

    /**
     * The team model class name.
     *
     * @var string
     */
    public static $teamModel = 'App\Team';

    /**
     * Indicates that users can create additional teams from the dashboard.
     *
     * @var bool
     */
    public static $createsAdditionalTeams = true;

    /**
     * The name used in the URI and interface to describe a team.
     *
     * @var string
     */
    public static $teamString = 'team';

    /**
     * Set the user model class name.
     *
     * @param  string  $userModel
     * @return void
     */
    public static function useUserModel($userModel)
    {
        static::$userModel = $userModel;
    }

    /**
     * Get the user model class name.
     *
     * @return string
     */
    public static function userModel()
    {
        return static::$userModel;
    }

    /**
     * Get a new user model instance.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public static function user()
    {
        return new static::$userModel;
    }

    /**
     * Set the team model class name.
     *
     * @param  string  $teamModel
     * @return void
     */
    public static function useTeamModel($teamModel)
    {
        static::$teamModel = $teamModel;
    }

    /**
     * Determine if the application offers support for teams.
     *
     * @return bool
     */
    public static function usesTeams()
    {
        return in_array(CanJoinTeams::class, class_uses_recursive(static::userModel()));
    }

    /**
     * Get the team model class name.
     *
     * @return string
     */
    public static function teamModel()
    {
        return static::$teamModel;
    }

    /**
     * Get a new team model instance.
     *
     * @return \Laravel\Spark\Team
     */
    public static function team()
    {
        return new static::$teamModel;
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
     * @return void
     */
    public static function noAdditionalTeams()
    {
        static::$createsAdditionalTeams = false;
    }

    /**
     * Get the string used to describe a team.
     *
     * @return string
     */
    public static function teamString()
    {
        return static::$teamString;
    }

    /**
     * Set the string used to describe a team.
     *
     * @param  string  $string
     * @return void
     */
    public static function referToTeamAs($string)
    {
        static::$teamString = $string;
    }
}
