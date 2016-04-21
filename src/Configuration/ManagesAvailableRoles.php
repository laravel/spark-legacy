<?php

namespace Laravel\Spark\Configuration;

trait ManagesAvailableRoles
{
    /**
     * The available team member roles.
     *
     * @var array
     */
    public static $roles = [];

    /**
     * The default role to be applied to new team members.
     *
     * @var string
     */
    public static $defaultRole = 'member';

    /**
     * Get the available team member roles.
     *
     * @return array
     */
    public static function roles()
    {
        return static::$roles;
    }

    /**
     * Define the roles available to team members.
     *
     * @param  array  $roles
     * @return void
     */
    public static function useRoles(array $roles)
    {
        static::$roles = $roles;
    }

    /**
     * Get the default role to be used by new team members.
     *
     * @return string
     */
    public static function defaultRole()
    {
        return static::$defaultRole;
    }

    /**
     * Set the default role to be used by new team members.
     *
     * @param  string  $role
     * @return void
     */
    public static function useDefaultRole($role)
    {
        static::$defaultRole = $role;
    }
}
