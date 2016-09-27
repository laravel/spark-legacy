<?php

namespace Laravel\Spark\Configuration;

use Laravel\Passport\Passport;

trait ManagesApiOptions
{
    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    public static $usesApi = false;

    /**
     * The abilities that may be assigned to tokens.
     *
     * @var array
     */
    public static $tokensCan = [];

    /**
     * The abilities that tokens are assigned by default in the UI.
     *
     * @var array
     */
    public static $tokenDefaults = [];

    /**
     * Determines if the application is exposing an API.
     *
     * @return bool
     */
    public static function usesApi()
    {
        return static::$usesApi;
    }

    /**
     * Specifies that the application will expose an API.
     *
     * @return void
     */
    public static function useApi()
    {
        static::$usesApi = true;
    }

    /**
     * Get or set the abilities that may be assigned to tokens.
     *
     * @param  array  $abilities
     * @return array|void
     */
    public static function tokensCan(array $abilities = null)
    {
        if (is_null($abilities)) {
            return static::$tokensCan;
        } else {
            static::$tokensCan = $abilities;

            if (class_exists('Laravel\Passport\Passport')) {
                Passport::tokensCan($abilities);
            }
        }
    }

    /**
     * Get the default token abilities to "check" in the UI.
     *
     * @param  array  $defaults
     * @return array|null
     */
    public static function tokenDefaults()
    {
        return static::$tokenDefaults;
    }

    /**
     * Set the default token abilities to "check" in the UI.
     *
     * @param  array  $defaults
     * @return array|null
     */
    public static function byDefaultTokensCan(array $defaults)
    {
        static::$tokenDefaults = $defaults;
    }
}
