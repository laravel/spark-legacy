<?php

namespace Laravel\Spark\Contracts\Interactions\Settings\PaymentMethod;

interface RedeemCoupon
{
    /**
     * Redeem a coupon for the given billable entity.
     *
     * @param  mixed  $billable
     * @param  string  $coupon
     * @return void
     */
    public function handle($billable, $coupon);
}
