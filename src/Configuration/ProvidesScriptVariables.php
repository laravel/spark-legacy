<?php

namespace Laravel\Spark\Configuration;

use Laravel\Spark\Spark;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Contracts\InitialFrontendState;
use Braintree\ClientToken as BraintreeClientToken;

trait ProvidesScriptVariables
{
    /**
     * Get the default JavaScript variables for Spark.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'translations' => (array) json_decode(file_get_contents(resource_path('lang/'.app()->getLocale().'.json'))) + ['teams.team' => trans('teams.team'), 'teams.member' => trans('teams.member')],
            'braintreeMerchantId' => config('services.braintree.merchant_id'),
            'braintreeToken' => Spark::billsUsingBraintree() ? BraintreeClientToken::generate() : null,
            'cardUpFront' => Spark::needsCardUpFront(),
            'collectsBillingAddress' => Spark::collectsBillingAddress(),
            'collectsEuropeanVat' => Spark::collectsEuropeanVat(),
            'createsAdditionalTeams' => Spark::createsAdditionalTeams(),
            'csrfToken' => csrf_token(),
            'currencySymbol' => Cashier::usesCurrencySymbol(),
            'env' => config('app.env'),
            'roles' => Spark::roles(),
            'state' => Spark::call(InitialFrontendState::class.'@forUser', [Auth::user()]),
            'stripeKey' => config('services.stripe.key'),
            'teamsPrefix' => Spark::teamsPrefix(),
            'userId' => Auth::id(),
            'usesApi' => Spark::usesApi(),
            'usesBraintree' => Spark::billsUsingBraintree(),
            'usesTeams' => Spark::usesTeams(),
            'usesStripe' => Spark::billsUsingStripe(),
            'chargesUsersPerSeat' => Spark::chargesUsersPerSeat(),
            'seatName' => Spark::seatName(),
            'chargesTeamsPerSeat' => Spark::chargesTeamsPerSeat(),
            'teamSeatName' => Spark::teamSeatName(),
            'chargesUsersPerTeam' => Spark::chargesUsersPerTeam(),
            'chargesTeamsPerMember' => Spark::chargesTeamsPerMember(),
        ];
    }
}
