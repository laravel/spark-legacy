<?php

namespace Laravel\Spark\Listeners\Profile;

use Braintree\Customer as BraintreeCustomer;

class UpdateContactInformationOnBraintree
{
    /**
     * Handle the event.
     *
     * @param  \Laravel\Spark\Events\Profile\ContactInformationUpdated  $event
     */
    public function handle($event)
    {
        if (! $event->user->hasBillingProvider()) {
            return;
        }

        BraintreeCustomer::update($event->user->braintree_id, [
            'email' => $event->user->email,
        ]);
    }
}
