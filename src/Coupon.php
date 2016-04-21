<?php

namespace Laravel\Spark;

class Coupon
{
    /**
     * The duration of the coupon (once, repeating, or forever).
     *
     * @var string
     */
    public $duration;

    /**
     * The duration of the coupon in months.
     *
     * @var int|null
     */
    public $durationInMonths;

    /**
     * The amount off the coupon provides.
     *
     * @var int
     */
    public $amountOff;

    /**
     * The percent off the coupon provides.
     *
     * @var int
     */
    public $percentOff;

    /**
     * Create a new coupon instance.
     *
     * @param  string  $duration
     * @param  int|null  $durationInMonths
     * @param  int  $amountOff
     * @param  int  $percentOff
     * @return void
     */
    public function __construct($duration, $durationInMonths = null, $amountOff = 0, $percentOff = 0)
    {
        $this->duration = $duration;
        $this->amountOff = $amountOff;
        $this->percentOff = $percentOff;
        $this->durationInMonths = $durationInMonths;
    }

    /**
     * Get the array form of the coupon.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'amount_off' => $this->amountOff,
            'duration' => $this->duration,
            'duration_in_months' => $this->durationInMonths,
            'percent_off' => $this->percentOff,
        ];
    }
}
