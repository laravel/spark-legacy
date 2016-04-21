<?php

namespace Laravel\Spark\Events\PaymentMethod;

class VatIdUpdated
{
    /**
     * The billable instance.
     *
     * @var mixed
     */
    public $billable;

    /**
     * Create a new event instance.
     *
     * @param mixed  $billable
     * @return void
     */
    public function __construct($billable)
    {
        $this->billable = $billable;
    }
}
