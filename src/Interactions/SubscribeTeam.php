<?php

namespace Laravel\Spark\Interactions;

use Laravel\Spark\Spark;
use Laravel\Spark\Contracts\Repositories\TeamRepository;
use Laravel\Spark\Events\Teams\Subscription\TeamSubscribed;
use Laravel\Spark\Contracts\Interactions\SubscribeTeam as Contract;

class SubscribeTeam implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function handle($team, $plan, array $data)
    {
        $subscription = $team->newSubscription('default', $plan->id);

        // Here we will fill the trial days for this team subscription. We will also set any
        // coupon on the subscription so that the team can receive a discount on the team
        // subscription. Then we will almost be ready to create the final subscription.
        $subscription->trialDays($plan->trialDays);

        if (isset($data['coupon'])) {
            $subscription->withCoupon($data['coupon']);
        }

        // Next, we need to check if this application is storing billing addresses and if so
        // we will update the billing address in the database so that any tax information
        // on the team will be up to date via the taxPercentage method on the billable.
        if (Spark::collectsBillingAddress()) {
            Spark::call(
                TeamRepository::class.'@updateBillingAddress',
                [$team, $data]
            );
        }

        // If this application collects European VAT, we will store the VAT ID that was sent
        // with the request. It is used to determine if the VAT should get charged at all
        // when billing the customer. When it is present, VAT is not typically charged.
        if (Spark::collectsEuropeanVat()) {
            Spark::call(
                TeamRepository::class.'@updateVatId',
                [$team, array_get($data, 'vat_id')]
            );
        }

        // Here we will create the actual subscription on the service and fire off the event
        // letting other listeners know a team has subscribed, which will allow any hooks
        // to fire that need to send the subscription data to any external metrics app.
        $subscription->create($data[$this->token]);

        event(new TeamSubscribed(
            $team = $team->fresh(), $plan
        ));

        return $team;
    }
}
