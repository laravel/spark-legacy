<?php

namespace Laravel\Spark\Interactions;

class SubscribeUsingStripe extends Subscribe
{
    /**
     * The token field to be used during subscription.
     *
     * @var string
     */
    protected $token = 'stripe_token';
}
