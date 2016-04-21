<?php

namespace Laravel\Spark\Providers;

use Laravel\Spark\Spark;
use Braintree_Configuration;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [];

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = null;

    /**
     * The available team member roles.
     *
     * @var array
     */
    protected $roles = [];

    /**
     * Indicates if two-factor authentication should be offered.
     *
     * @var bool
     */
    protected $usesTwoFactorAuth = false;

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = true;

    /**
     * All of the abilities that may be assigned to API tokens.
     *
     * @var array
     */
    protected $tokensCan = [];

    /**
     * The token abilities that should be selected by default in the UI.
     *
     * @var array
     */
    protected $byDefaultTokensCan = [];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Spark::details($this->details);

        Spark::sendSupportEmailsTo($this->sendSupportEmailsTo);

        if (count($this->developers) > 0) {
            Spark::developers($this->developers);
        }

        if (count($this->roles) > 0) {
            Spark::useRoles($this->roles);
        }

        if ($this->usesTwoFactorAuth) {
            Spark::useTwoFactorAuth();
        }

        if ($this->usesApi) {
            Spark::useApi();
        }

        Spark::tokensCan($this->tokensCan);

        Spark::byDefaultTokensCan($this->byDefaultTokensCan);

        $this->booted();

        if (Spark::billsUsingBraintree()) {
            $this->configureBraintree();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Configure the Braintree SDK.
     *
     * @return void
     */
    protected function configureBraintree()
    {
        Braintree_Configuration::environment(config('services.braintree.env'));
        Braintree_Configuration::merchantId(config('services.braintree.merchant_id'));
        Braintree_Configuration::publicKey(config('services.braintree.key'));
        Braintree_Configuration::privateKey(config('services.braintree.secret'));
    }
}
