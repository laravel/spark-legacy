<?php

namespace Laravel\Spark\Http\Requests\Auth;

use Laravel\Spark\Spark;
use Laravel\Spark\Http\Requests\ValidatesBillingAddresses;
use Laravel\Spark\Contracts\Http\Requests\Auth\RegisterRequest as Contract;

class StripeRegisterRequest extends RegisterRequest implements Contract
{
    use ValidatesBillingAddresses;

    /**
     * Get the validator for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator()
    {
        $validator = $this->registerValidator(['stripe_token']);

        if (Spark::collectsBillingAddress() && $this->hasPaidPlan()) {
            $this->validateBillingAddress($validator);
        }

        return $validator;
    }
}
