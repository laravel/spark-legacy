<?php

namespace Laravel\Spark\Interactions\Settings\PaymentMethod;

use Laravel\Spark\User;
use Laravel\Spark\Spark;
use Laravel\Spark\Contracts\Repositories\UserRepository;
use Laravel\Spark\Contracts\Repositories\TeamRepository;
use Laravel\Spark\Contracts\Interactions\Settings\PaymentMethod\UpdatePaymentMethod;

class UpdateStripePaymentMethod implements UpdatePaymentMethod
{
    /**
     * {@inheritdoc}
     */
    public function handle($billable, array $data)
    {
        // Next, we need to check if this application is storing billing addresses and if so
        // we will update the billing address in the database so that any tax information
        // on the user will be up to date via the taxPercentage method on the billable.
        if (Spark::collectsBillingAddress()) {
            Spark::call(
                $this->updateBillingAddressMethod($billable),
                [$billable, $data]
            );
        }

        // If a billable entity already has a Stripe ID, we will just update their card then
        // return, but if entities do not have a Stripe ID, we'll need to create a Stripe
        // customer with this given token so that they really exist in Stripe's system.
        if ($billable->stripe_id) {
            $billable->updateCard($data['stripe_token']);
        } else {
            $billable->createAsStripeCustomer($data['stripe_token']);
        }
    }

    /**
     * Get the repository class name for a given billable instance.
     *
     * @param  mixed  $billable
     * @return string
     */
    protected function updateBillingAddressMethod($billable)
    {
        return ($billable instanceof User
                    ? UserRepository::class
                    : TeamRepository::class).'@updateBillingAddress';
    }
}
