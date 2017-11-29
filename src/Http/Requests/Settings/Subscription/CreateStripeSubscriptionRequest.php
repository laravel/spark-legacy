<?php

namespace Laravel\Spark\Http\Requests\Settings\Subscription;

use Laravel\Spark\Spark;
use Illuminate\Support\Facades\Validator;
use Laravel\Spark\Http\Requests\ValidatesBillingAddresses;
use Laravel\Spark\Contracts\Http\Requests\Settings\Subscription\CreateSubscriptionRequest as Contract;

class CreateStripeSubscriptionRequest extends CreateSubscriptionRequest implements Contract
{
    use ValidatesBillingAddresses;

    /**
     * Get the validator for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator()
    {
        $validator = Validator::make($this->all(), [
            'stripe_token' => 'required_if:existing_card,0',
            'plan' => 'required|in:'.Spark::activePlanIdList(),
            'vat_id' => 'nullable|max:50|vat_id',
        ]);

        if (Spark::collectsBillingAddress()) {
            $this->validateBillingAddress($validator);
        }

        return $validator->after(function ($validator) {
            $this->validatePlanEligibility($validator);

            if ($this->coupon) {
                $this->validateCoupon($validator);
            }
        });
    }
}
