<?php

namespace Laravel\Spark\Interactions\Settings\PaymentMethod;

use Laravel\Spark\Contracts\Interactions\Settings\PaymentMethod\RedeemCoupon;

class RedeemStripeCoupon implements RedeemCoupon
{
    /**
     * {@inheritdoc}
     */
    public function handle($billable, $coupon)
    {
        $billable->applyCoupon($coupon);
    }
}
