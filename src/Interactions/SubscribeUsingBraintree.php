<?php

namespace Laravel\Spark\Interactions;

class SubscribeUsingBraintree extends Subscribe
{
    /**
     * The token field to be used during subscription.
     *
     * @var string
     */
    protected $token = 'braintree_token';
}
