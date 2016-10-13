<?php

namespace Laravel\Spark\Configuration;

trait ManagesAppOptions
{
    /**
     * Where to redirect users after authentication.
     *
     * @var string
     */
    public static $authRedirect = '/home';

    /**
     * Where to redirect users after authentication.
     *
     * @return string
     */
    public static function authRedirect()
    {
        return static::$authRedirect;
    }

    /**
     * Set the path to redirect to after authentication.
     *
     * @return void
     */
    public static function redirectionPathAfterAuth($path)
    {
        static::$authRedirect = $path;
    }
}