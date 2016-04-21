<?php

namespace Laravel\Spark\Http\Requests\Auth;

use Laravel\Spark\Contracts\Http\Requests\Auth\RegisterRequest as Contract;

class BraintreeRegisterRequest extends RegisterRequest implements Contract
{
    /**
     * Get the validator for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator()
    {
        return $this->registerValidator(['braintree_type', 'braintree_token']);
    }
}
