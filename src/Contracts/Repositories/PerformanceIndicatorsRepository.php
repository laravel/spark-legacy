<?php

namespace Laravel\Spark\Contracts\Repositories;

use Carbon\Carbon;
use Laravel\Spark\Plan;

interface PerformanceIndicatorsRepository
{
    /**
     * Get all of the performance indicator records.
     *
     * @param  int  $take
     * @return array
     */
    public function all($take = 60);

    /**
     * Get the performance indicators for a specific date.
     *
     * @param  \Carbon\Carbon  $date
     * @return \StdClass
     */
    public function forDate(Carbon $date);

    /**
     * Get the total lifetime revenue for a given user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return float
     */
    public function totalRevenueForUser($user);

    /**
     * Get the total volume of the application.
     *
     * @return float
     */
    public function totalVolume();

    /**
     * Get the total yearly recurring revenue.
     *
     * @return float
     */
    public function yearlyRecurringRevenue();

    /**
     * Get the monthly recurring revenue.
     *
     * @return float
     */
    public function monthlyRecurringRevenue();

    /**
     * Get the subscriber count for the given plan.
     *
     * @param  \Laravel\Spark\Plan  $plan
     * @return int
     */
    public function subscribers(Plan $plan);

    /**
     * Get the trialing count for the given plan.
     *
     * @param  \Laravel\Spark\Plan  $plan
     * @return float
     */
    public function trialing(Plan $plan);
}
