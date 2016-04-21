<?php

namespace Laravel\Spark\Services;

use Stripe\Token as StripeToken;

class Stripe
{
    /**
     * Get the country code for the given Stripe token.
     *
     * @param  string  $token
     * @return string
     */
    public function countryForToken($token)
    {
        return StripeToken::retrieve(
            $token, config('services.stripe.secret')
        )->card->country;
    }

    /**
     * Verify that the given token origin country matches the given country.
     *
     * @param  string  $token
     * @param  string  $country
     * @return bool
     */
    public function tokenIsForCountry($token, $country)
    {
        return $this->countryForToken($token) === $country;
    }
}
