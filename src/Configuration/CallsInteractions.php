<?php

namespace Laravel\Spark\Configuration;

use Closure;
use Illuminate\Support\Str;
use Laravel\Spark\Contracts\Interactions\CheckPlanEligibility;
use Laravel\Spark\Contracts\Interactions\CheckTeamPlanEligibility;

trait CallsInteractions
{
    /**
     * The alternative implementation of interaction methods.
     *
     * @var array
     */
    public static $interactions = [];

    /**
     * Run an interaction method.
     *
     * @param  string  $interaction
     * @param  array  $parameters
     * @return mixed
     */
    public static function call($interaction, array $parameters = [])
    {
        return static::interact($interaction, $parameters);
    }

    /**
     * Run an interaction method.
     *
     * @param  string  $interaction
     * @param  array  $parameters
     * @param  string  $original
     * @return mixed
     */
    public static function interact($interaction, array $parameters = [], $original = null)
    {
        if (! Str::contains($interaction, '@')) {
            $interaction = $interaction.'@handle';
        }

        list($class, $method) = explode('@', $interaction);

        if (isset(static::$interactions[$interaction])) {
            return static::callSwappedInteraction($interaction, $parameters, $class, $interaction);
        }

        $base = class_basename($class);

        if (isset(static::$interactions[$base.'@'.$method])) {
            return static::callSwappedInteraction($base.'@'.$method, $parameters, $class, $interaction);
        }

        $instance = app($class);

        // If an original interaction is available, we will create an instance of that
        // interaction and make it available as a class property in the user defined
        // class. That way developers may call other methods in the original class.
        if ($original) {
            list($originalClass) = explode('@', $original);

            $instance->originalInteraction = app($originalClass);
        }

        return call_user_func_array([$instance, $method], $parameters);
    }

    /**
     * Run a swapped interaction method.
     *
     * @param  string  $interaction
     * @param  array  $parameters
     * @param  string  $original
     * @return mixed
     */
    protected static function callSwappedInteraction($interaction, array $parameters, $class, $original)
    {
        if (is_string(static::$interactions[$interaction])) {
            return static::interact(static::$interactions[$interaction], $parameters, $original);
        }

        $instance = app($class);

        $method = static::$interactions[$interaction]->bindTo($instance, $instance);

        return call_user_func_array($method, $parameters);
    }

    /**
     * Swap the implementation of an interaction method.
     *
     * @param  string  $interaction
     * @param  mixed  $callback
     * @return void
     */
    public static function swap($interaction, $callback)
    {
        static::$interactions[$interaction] = $callback;
    }

    /**
     * Register a callback to provide the rules for new users.
     *
     * @param  mixed  $callback
     * @return void
     */
    public static function validateUsersWith($callback)
    {
        return static::swap('CreateUser@rules', $callback);
    }

    /**
     * Register a callback to create new users.
     *
     * @param  mixed  $callback
     * @return void
     */
    public static function createUsersWith($callback)
    {
        return static::swap('CreateUser@handle', $callback);
    }

    /**
     * Set a callback to be used to check plan eligibility.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function checkPlanEligibilityUsing($callback)
    {
        static::swap('CheckPlanEligibility@handle', $callback);
    }

    /**
     * Determine if the user is eligible for the given plan.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    public static function eligibleForPlan($user, $plan)
    {
        return static::call(CheckPlanEligibility::class.'@handle', [$user, $plan]);
    }

    /**
     * Set a callback to be used to check team plan eligibility.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function checkTeamPlanEligibilityUsing(Closure $callback)
    {
        static::swap('CheckTeamPlanEligibility@handle', $callback);
    }

    /**
     * Determine if the team is eligible for the given plan.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    public static function eligibleForTeamPlan($team, $plan)
    {
        return static::call(CheckTeamPlanEligibility::class.'@handle', [$team, $plan]);
    }
}
