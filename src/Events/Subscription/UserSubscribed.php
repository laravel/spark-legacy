<?php

namespace Laravel\Spark\Events\Subscription;

class UserSubscribed
{
    /**
     * The user instance.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * The plan the user subscribed to.
     *
     * @var \Laravel\Spark\Plan
     */
    public $plan;

    /**
     * Indicates if the user was performing initial registration.
     *
     * @var bool
     */
    public $fromRegistration;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Laravel\Spark\Plan  $plan
     * @param  bool  $fromRegistration
     * @return void
     */
    public function __construct($user, $plan, $fromRegistration)
    {
        $this->user = $user;
        $this->plan = $plan;
        $this->fromRegistration = $fromRegistration;
    }
}
