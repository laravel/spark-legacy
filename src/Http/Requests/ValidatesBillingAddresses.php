<?php

namespace Laravel\Spark\Http\Requests;

use Laravel\Spark\Services\Stripe as StripeService;

trait ValidatesBillingAddresses
{
    /**
     * Merges billing address validation rules into the given validator.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function validateBillingAddress($validator)
    {
        $this->mergeCardCountryIntoRequest();

        $validator->addRules([
            'address' => 'required|max:255',
            'address_line_2' => 'max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255|state:'.$this->country,
            'zip' => 'required|max:25',
            'country' => 'required|max:2|country',
        ]);

        $validator->after(function ($validator) {
            $this->validateLocation($validator);
        });
    }

    /**
     * Merge the billing card country into the request.
     *
     * @return void
     */
    protected function mergeCardCountryIntoRequest()
    {
        if (! $this->stripe_token) {
            return;
        }

        $this->merge(['card_country' => app(StripeService::class)->countryForToken(
            $this->stripe_token
        )]);
    }

    /**
     * Validate that the request's location information agrees.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function validateLocation($validator)
    {
        if (! app(StripeService::class)->tokenIsForCountry($this->stripe_token, $this->country)) {
            $validator->errors()->add(
                'country', __('This country does not match the origin country of your card.')
            );
        }
    }
}
