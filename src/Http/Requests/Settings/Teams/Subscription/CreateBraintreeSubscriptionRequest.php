<?php

namespace Laravel\Spark\Http\Requests\Settings\Teams\Subscription;

use Laravel\Spark\Contracts\Http\Requests\Settings\Teams\Subscription\CreateSubscriptionRequest as Contract;

class CreateBraintreeSubscriptionRequest extends CreateSubscriptionRequest implements Contract
{
    /**
     * Get the validator for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator()
    {
        return $this->baseValidator([
            'braintree_type' => 'required',
            'braintree_token' => 'required',
        ]);
    }
}
