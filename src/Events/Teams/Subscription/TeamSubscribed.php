<?php

namespace Laravel\Spark\Events\Teams\Subscription;

class TeamSubscribed
{
    /**
     * The team instance.
     *
     * @var \Laravel\Spark\Team
     */
    public $team;

    /**
     * The plan the team subscribed to.
     *
     * @var \Laravel\Spark\Plan
     */
    public $plan;

    /**
     * Create a new event instance.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  \Laravel\Spark\Plan  $plan
     * @return void
     */
    public function __construct($team, $plan)
    {
        $this->team = $team;
        $this->plan = $plan;
    }
}
