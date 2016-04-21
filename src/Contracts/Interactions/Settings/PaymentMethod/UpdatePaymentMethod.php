<?php

namespace Laravel\Spark\Contracts\Interactions\Settings\PaymentMethod;

interface UpdatePaymentMethod
{
    /**
     * Update the billable entity's payment method.
     *
     * @param  mixed  $billable
     * @param  array  $data
     * @return void
     */
    public function handle($billable, array $data);
}
