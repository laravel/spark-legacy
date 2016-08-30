<?php

namespace Laravel\Spark\Configuration;

use Exception;

trait ManagesBillingProviders
{
    /**
     * Indicates if the application requires a credit card up-front.
     *
     * @var bool
     */
    public static $cardUpFront = true;

    /**
     * Indicates the service the application uses for billing.
     *
     * @var bool
     */
    public static $billsUsing = 'stripe';

    /**
     * Indicates if the application collects the customer's billing address.
     *
     * @var bool
     */
    public static $collectsBillingAddress = false;

    /**
     * Indicates if the application collects European VAT.
     *
     * @var bool
     */
    public static $collectsEuropeanVat = false;

    /**
     * The application's home country where the business is incorporated.
     *
     * This value should be a two-digit country code.
     *
     * @var string
     */
    public static $homeCountry;

    /**
     * Indicates that the application does not require a card up front.
     *
     * @return static
     */
    public static function noCardUpFront()
    {
        static::$cardUpFront = false;

        return new static;
    }

    /**
     * Determine if the application requires a card up front.
     *
     * @return bool
     */
    public static function needsCardUpFront()
    {
        return static::$cardUpFront;
    }

    /**
     * Determine if the application bills customers using a given provider.
     *
     * @param  string  $provider
     * @return bool
     */
    public static function billsUsing($provider)
    {
        return static::$billsUsing === $provider;
    }

    /**
     * Determine if the application bills customers using Stripe.
     *
     * @return bool
     */
    public static function billsUsingStripe()
    {
        return static::billsUsing('stripe');
    }

    /**
     * Indicate that the application should use Stripe for billing.
     *
     * @return static
     */
    public static function useStripe()
    {
        static::$billsUsing = 'stripe';

        return new static;
    }

    /**
     * Determine if the application bills customers using Braintree.
     *
     * @return bool
     */
    public static function billsUsingBraintree()
    {
        return static::billsUsing('braintree');
    }

    /**
     * Indicate that the application should use Braintree for billing.
     *
     * Swaps out bindings in the container for Braintree.
     *
     * @return static
     */
    public static function useBraintree()
    {
        static::$billsUsing = 'braintree';

        $services = [
            'Contracts\Http\Requests\Auth\RegisterRequest' => 'Http\Requests\Auth\BraintreeRegisterRequest',
            'Contracts\Http\Requests\Settings\Subscription\CreateSubscriptionRequest' => 'Http\Requests\Settings\Subscription\CreateBraintreeSubscriptionRequest',
            'Contracts\Http\Requests\Settings\Teams\Subscription\CreateSubscriptionRequest' => 'Http\Requests\Settings\Teams\Subscription\CreateBraintreeSubscriptionRequest',
            'Contracts\Http\Requests\Settings\PaymentMethod\UpdatePaymentMethodRequest' => 'Http\Requests\Settings\PaymentMethod\UpdateBraintreePaymentMethodRequest',
            'Contracts\Repositories\CouponRepository' => 'Repositories\BraintreeCouponRepository',
            'Contracts\Repositories\LocalInvoiceRepository' => 'Repositories\BraintreeLocalInvoiceRepository',
            'Contracts\Interactions\Subscribe' => 'Interactions\SubscribeUsingBraintree',
            'Contracts\Interactions\SubscribeTeam' => 'Interactions\SubscribeTeamUsingBraintree',
            'Contracts\Interactions\Settings\PaymentMethod\UpdatePaymentMethod' => 'Interactions\Settings\PaymentMethod\UpdateBraintreePaymentMethod',
            'Contracts\Interactions\Settings\PaymentMethod\RedeemCoupon' => 'Interactions\Settings\PaymentMethod\RedeemBraintreeCoupon',
        ];

        $app = app();

        foreach ($services as $key => $value) {
            $app->singleton('Laravel\Spark\\'.$key, 'Laravel\Spark\\'.$value);
        }

        return new static;
    }

    /**
     * Indicate that the application should collect the customer's billing address.
     *
     * @param  bool  $value
     * @return static
     * 
     * @throws \Exception
     */
    public static function collectBillingAddress($value = true)
    {
        if ($value && static::billsUsingBraintree()) {
            throw new Exception("Collecting billing addresses is only supported when using Stripe.");
        }

        static::$collectsBillingAddress = $value;

        return new static;
    }

    /**
     * Determine if the application collects the customer's billing address.
     *
     * @return bool
     */
    public static function collectsBillingAddress()
    {
        return static::$collectsBillingAddress;
    }

    /**
     * Indicate that the application should collect European VAT.
     *
     * @param  string|null  $homeCountry
     * @param  bool  $value
     * @return static
     */
    public static function collectEuropeanVat($homeCountry = null, $value = true)
    {
        static::$homeCountry = $homeCountry;
        static::$collectsEuropeanVat = $value;

        return static::collectBillingAddress($value);
    }

    /**
     * Determine if the application collects European VAT.
     *
     * @return bool
     */
    public static function collectsEuropeanVat()
    {
        return static::$collectsEuropeanVat;
    }

    /**
     * Get the home country the business is incorporated in.
     *
     * @return string|null
     */
    public static function homeCountry()
    {
        return static::$homeCountry;
    }
}
