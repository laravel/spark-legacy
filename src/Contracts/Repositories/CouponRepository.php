<?php

namespace Laravel\Spark\Contracts\Repositories;

interface CouponRepository
{
    /**
     * Determine if the given coupon code is valid.
     *
     * @param  string  $code
     * @return bool
     */
    public function valid($code);

    /**
     * Determine if the coupon may be redeemed by an existing customer.
     *
     * @param  string  $code
     * @return bool
     */
    public function canBeRedeemed($code);

    /**
     * Get the coupon data for the given code.
     *
     * @param  string  $code
     * @return mixed
     */
    public function find($code);

    /**
     * Get the current coupon for the given billable entity.
     *
     * @param  mixed  $billable
     * @return mixed
     */
    public function forBillable($billable);
}
