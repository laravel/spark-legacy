<?php

namespace Laravel\Spark\Configuration;

trait ManagesTwoFactorOptions
{
    /**
     * Indicates if two-factor authentication is being offered.
     *
     * @var bool
     */
    public static $usesTwoFactorAuth = false;

    /**
     * Determines if two-factor authentication is being offered.
     *
     * @return bool
     */
    public static function usesTwoFactorAuth()
    {
        return static::$usesTwoFactorAuth;
    }

    /**
     * Specifies that two-factor authentication should be offered.
     *
     * @return void
     */
    public static function useTwoFactorAuth()
    {
        static::$usesTwoFactorAuth = true;
    }
}
