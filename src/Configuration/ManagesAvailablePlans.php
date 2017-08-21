<?php

namespace Laravel\Spark\Configuration;

use Laravel\Spark\Plan;
use Laravel\Spark\TeamPlan;

trait ManagesAvailablePlans
{
    /**
     * Indicates that the application will bill customers.
     *
     * @var bool
     */
    public static $billsCustomers = false;

    /**
     * Indicates that the application will bill teams.
     *
     * @var bool
     */
    public static $billsTeams = false;

    /**
     * The coupon code for the current application wide promotion.
     *
     * @var string
     */
    public static $promotion;

    /**
     * The number of days to grant to generic trials.
     *
     * @var int
     */
    public static $trialDays;

    /**
     * The number of days to grant to generic team trials.
     *
     * @var int
     */
    public static $teamTrialDays;

    /**
     * All of the plans defined for the application.
     *
     * @var array
     */
    public static $plans = [];

    /**
     * All of the team plans defined for the application.
     *
     * @var array
     */
    public static $teamPlans = [];

    /**
     * Indicates that the application will bill customers.
     *
     * @return void
     */
    public static function billsCustomers()
    {
        static::$billsCustomers = true;
    }

    /**
     * Determine if the application bills customers.
     *
     * @return bool
     */
    public static function canBillCustomers()
    {
        return static::hasPaidPlans() || static::$billsCustomers;
    }

    /**
     * Indicates that the application will bill teams.
     *
     * @return void
     */
    public static function billsTeams()
    {
        static::$billsTeams = true;
    }

    /**
     * Determine if the application bills customers.
     *
     * @return bool
     */
    public static function canBillTeams()
    {
        return static::hasPaidTeamPlans() || static::$billsTeams;
    }

    /**
     * Define or retrieve an application wide promotion for new registrations.
     *
     * @param  string|null  $coupon
     * @return string|void
     */
    public static function promotion($coupon = null)
    {
        if (is_null($coupon)) {
            return static::$promotion;
        } else {
            static::$promotion = $coupon;
        }
    }

    /**
     * Get or set the number of days for the generic trial.
     *
     * @param  int|null  $trialDays
     * @return static|int
     */
    public static function trialDays($trialDays = null)
    {
        if (is_null($trialDays)) {
            return static::$trialDays;
        }

        static::$trialDays = $trialDays;

        return new static;
    }

    /**
     * Get or set the number of days for the generic team trial.
     *
     * @param  int|null  $teamTrialDays
     * @return static|int
     */
    public static function teamTrialDays($teamTrialDays = null)
    {
        if (is_null($teamTrialDays)) {
            return static::$teamTrialDays;
        }

        static::$teamTrialDays = $teamTrialDays;

        return new static;
    }

    /**
     * Create a new free plan instance.
     *
     * @param  string  $name
     * @return \Laravel\Spark\Plan
     */
    public static function freePlan($name = 'Free')
    {
        return static::plan($name, 'free');
    }

    /**
     * Create a new free team plan instance.
     *
     * @param  string  $name
     * @return \Laravel\Spark\Plan
     */
    public static function freeTeamPlan($name = 'Free')
    {
        return static::teamPlan($name, 'free');
    }

    /**
     * Create a new plan instance.
     *
     * @param  string  $name
     * @param  string  $id
     * @return \Laravel\Spark\Plan
     */
    public static function plan($name, $id)
    {
        static::$plans[] = $plan = new Plan($name, $id);

        return $plan;
    }

    /**
     * Create a new team plan instance.
     *
     * @param  string  $name
     * @param  string  $id
     * @return \Laravel\Spark\Plan
     */
    public static function teamPlan($name, $id)
    {
        static::$teamPlans[] = $plan = new TeamPlan($name, $id);

        return $plan;
    }

    /**
     * Determine if paid plans are defined for the application.
     *
     * @return bool
     */
    public static function hasPaidPlans()
    {
        return count(static::plans()->filter(function ($plan) {
            return $plan->price > 0;
        })) > 0;
    }

    /**
     * Determine if active yearly plans are defined.
     *
     * @return bool
     */
    public static function hasYearlyPlans()
    {
        return static::plans()->filter(function ($plan) {
            return $plan->interval === 'yearly';
        })->count() > 0;
    }

    /**
     * Get the active plans defined for the application.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function activePlans()
    {
        return static::plans()->filter(function ($plan) {
            return $plan->active;
        });
    }

    /**
     * Get the plans defined for the application.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function plans()
    {
        return collect(static::$plans)->map(function ($plan) {
            $plan->type = 'user';

            return $plan;
        });
    }

    /**
     * Get an array of all of the active plan IDs.
     *
     * @return array
     */
    public static function activePlanIds()
    {
        return static::activePlans()->pluck('id')->all();
    }

    /**
     * Get a comma delimited list of active Spark plan IDs.
     *
     * @return string
     */
    public static function activePlanIdList()
    {
        return implode(',', static::activePlanIds());
    }

    /**
     * Determine if paid team plans are defined for the application.
     *
     * @return bool
     */
    public static function hasPaidTeamPlans()
    {
        return count(static::teamPlans()->filter(function ($plan) {
            return $plan->price > 0;
        })) > 0;
    }

    /**
     * Determine if active team yearly plans are defined.
     *
     * @return bool
     */
    public static function hasYearlyTeamPlans()
    {
        return static::teamPlans()->filter(function ($plan) {
            return $plan->interval === 'yearly';
        })->count() > 0;
    }

    /**
     * Get the active team plans defined for the application.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function activeTeamPlans()
    {
        return static::teamPlans()->filter(function ($plan) {
            return $plan->active;
        });
    }

    /**
     * Get the team plans defined for the application.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function teamPlans()
    {
        return collect(static::$teamPlans)->map(function ($plan) {
            $plan->type = 'team';

            return $plan;
        });
    }

    /**
     * Get an array of all of the active team plan IDs.
     *
     * @return array
     */
    public static function activeTeamPlanIds()
    {
        return static::activeTeamPlans()->pluck('id')->all();
    }

    /**
     * Get a comma delimited list of active Spark team plan IDs.
     *
     * @return string
     */
    public static function activeTeamPlanIdList()
    {
        return implode(',', static::activeTeamPlanIds());
    }

    /**
     * Determine if the application has team plans only.
     *
     * @return bool
     */
    public static function onlyTeamPlans()
    {
        return static::plans()->isEmpty() && ! static::teamPlans()->isEmpty();
    }

    /**
     * Get all of the plans, both individual and teams.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function allPlans()
    {
        return static::plans()->merge(static::teamPlans());
    }

    /**
     * Get all of the monthly plans, both individual and teams.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function allMonthlyPlans()
    {
        return collect(array_merge(
            static::plans()->where('interval', 'monthly')->all(),
            static::teamPlans()->where('interval', 'monthly')->all()
        ));
    }

    /**
     * Get all of the yearly plans, both individual and teams.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function allYearlyPlans()
    {
        return collect(array_merge(
            static::plans()->where('interval', 'yearly')->all(),
            static::teamPlans()->where('interval', 'yearly')->all()
        ));
    }
}
