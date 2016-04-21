<?php

namespace Laravel\Spark\Listeners\Subscription;

class UpdateTaxPercentageOnStripe
{
    /**
     * Handle the event.
     *
     * @param  mixed  $event
     * @return void
     */
    public function handle($event)
    {
        $subscription = $event->billable->subscription();

        if (! $subscription || ! $subscription->valid()) {
            return;
        }

        $stripeSubscription = $subscription->asStripeSubscription();

        $stripeSubscription->tax_percent = $event->billable->taxPercentage();

        $stripeSubscription->save();
    }
}
