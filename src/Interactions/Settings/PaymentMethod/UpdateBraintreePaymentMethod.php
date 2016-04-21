<?php

namespace Laravel\Spark\Interactions\Settings\PaymentMethod;

use Laravel\Spark\Contracts\Interactions\Settings\PaymentMethod\UpdatePaymentMethod;

class UpdateBraintreePaymentMethod implements UpdatePaymentMethod
{
    /**
     * {@inheritdoc}
     */
    public function handle($billable, array $data)
    {
        if ($billable->braintree_id) {
            $billable->updateCard($data['braintree_token']);
        } else {
            $billable->createAsBraintreeCustomer($data['braintree_token']);
        }
    }
}
