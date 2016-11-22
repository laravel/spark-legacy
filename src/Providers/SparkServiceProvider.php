<?php

namespace Laravel\Spark\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\TokenGuard;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Laravel\Spark\Validation\StateValidator;
use Laravel\Spark\Validation\VatIdValidator;
use Laravel\Spark\Validation\CountryValidator;
use Laravel\Spark\Console\Commands\InstallCommand;
use Laravel\Spark\Console\Commands\UpdateCommand;
use Laravel\Spark\Console\Commands\VersionCommand;
use Laravel\Spark\Console\Commands\UpdateViewsCommand;
use Laravel\Spark\Console\Commands\StorePerformanceIndicatorsCommand;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->defineRoutes();

        $this->defineResources();

        Validator::extend('state', StateValidator::class.'@validate');
        Validator::extend('country', CountryValidator::class.'@validate');
        Validator::extend('vat_id', VatIdValidator::class.'@validate');

        Auth::viaRequest('spark', function ($request) {
            return app(TokenGuard::class)->user($request);
        });
    }

    /**
     * Define the Spark routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        $this->defineRouteBindings();

        // If the routes have not been cached, we will include them in a route group
        // so that all of the routes will be conveniently registered to the given
        // controller namespace. After that we will load the Spark routes file.
        if (! $this->app->routesAreCached()) {
            Route::group([
                'namespace' => 'Laravel\Spark\Http\Controllers'],
                function ($router) {
                    require __DIR__.'/../Http/routes.php';
                }
            );
        }
    }

    /**
     * Define the Spark route model bindings.
     *
     * @return void
     */
    protected function defineRouteBindings()
    {
        Route::model('team', Spark::teamModel());

        Route::model('team_member', Spark::userModel());
    }

    /**
     * Define the resources for the package.
     *
     * @return void
     */
    protected function defineResources()
    {
        $this->loadViewsFrom(SPARK_PATH.'/resources/views', 'spark');

        $this->loadTranslationsFrom(SPARK_PATH.'/resources/lang', 'spark');

        if ($this->app->runningInConsole()) {
            $this->defineViewPublishing();

            $this->defineAssetPublishing();

            $this->defineFullPublishing();
        }
    }

    /**
     * Define the view publishing configuration.
     *
     * @return void
     */
    public function defineViewPublishing()
    {
        $this->publishes([
            SPARK_PATH.'/resources/views' => resource_path('views/vendor/spark'),
        ], 'spark-views');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            SPARK_PATH.'/resources/assets/js' => resource_path('assets/js/spark'),
        ], 'spark-js');

        $this->publishes([
            SPARK_PATH.'/resources/assets/less' => resource_path('assets/less/spark'),
        ], 'spark-less');
    }

    /**
     * Define the "full" publishing configuration.
     *
     * @return void
     */
    public function defineFullPublishing()
    {
        $this->publishes([
            SPARK_PATH.'/resources/views' => resource_path('views/vendor/spark'),
            SPARK_PATH.'/resources/assets/js' => resource_path('assets/js/spark'),
            SPARK_PATH.'/resources/assets/less' => resource_path('assets/less/spark'),
        ], 'spark-full');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('SPARK_PATH')) {
            define('SPARK_PATH', realpath(__DIR__.'/../../'));
        }

        if (! class_exists('Spark')) {
            class_alias('Laravel\Spark\Spark', 'Spark');
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                UpdateCommand::class,
                UpdateViewsCommand::class,
                StorePerformanceIndicatorsCommand::class,
                VersionCommand::class,
            ]);
        }

        $this->registerServices();
    }

    /**
     * Register the Spark services.
     *
     * @return void
     */
    protected function registerServices()
    {
        $this->registerAuthyService();

        $this->registerInterventionService();

        $this->registerApiTokenRepository();

        $services = [
            'Contracts\Http\Requests\Auth\RegisterRequest' => 'Http\Requests\Auth\StripeRegisterRequest',
            'Contracts\Http\Requests\Settings\Subscription\CreateSubscriptionRequest' => 'Http\Requests\Settings\Subscription\CreateStripeSubscriptionRequest',
            'Contracts\Http\Requests\Settings\Teams\Subscription\CreateSubscriptionRequest' => 'Http\Requests\Settings\Teams\Subscription\CreateStripeSubscriptionRequest',
            'Contracts\Http\Requests\Settings\PaymentMethod\UpdatePaymentMethodRequest' => 'Http\Requests\Settings\PaymentMethod\UpdateStripePaymentMethodRequest',
            'Contracts\Repositories\AnnouncementRepository' => 'Repositories\AnnouncementRepository',
            'Contracts\Repositories\CouponRepository' => 'Repositories\StripeCouponRepository',
            'Contracts\Repositories\NotificationRepository' => 'Repositories\NotificationRepository',
            'Contracts\Repositories\TeamRepository' => 'Repositories\TeamRepository',
            'Contracts\Repositories\UserRepository' => 'Repositories\UserRepository',
            'Contracts\Repositories\LocalInvoiceRepository' => 'Repositories\StripeLocalInvoiceRepository',
            'Contracts\Repositories\PerformanceIndicatorsRepository' => 'Repositories\PerformanceIndicatorsRepository',
            'Contracts\Repositories\Geography\StateRepository' => 'Repositories\Geography\StateRepository',
            'Contracts\Repositories\Geography\CountryRepository' => 'Repositories\Geography\CountryRepository',
            'Contracts\InitialFrontendState' => 'InitialFrontendState',
            'Contracts\Interactions\Support\SendSupportEmail' => 'Interactions\Support\SendSupportEmail',
            'Contracts\Interactions\Subscribe' => 'Interactions\SubscribeUsingStripe',
            'Contracts\Interactions\SubscribeTeam' => 'Interactions\SubscribeTeamUsingStripe',
            'Contracts\Interactions\CheckPlanEligibility' => 'Interactions\CheckPlanEligibility',
            'Contracts\Interactions\CheckTeamPlanEligibility' => 'Interactions\CheckTeamPlanEligibility',
            'Contracts\Interactions\Auth\CreateUser' => 'Interactions\Auth\CreateUser',
            'Contracts\Interactions\Auth\Register' => 'Interactions\Auth\Register',
            'Contracts\Interactions\Settings\Profile\UpdateProfilePhoto' => 'Interactions\Settings\Profile\UpdateProfilePhoto',
            'Contracts\Interactions\Settings\Profile\UpdateContactInformation' => 'Interactions\Settings\Profile\UpdateContactInformation',
            'Contracts\Interactions\Settings\Teams\CreateTeam' => 'Interactions\Settings\Teams\CreateTeam',
            'Contracts\Interactions\Settings\Teams\AddTeamMember' => 'Interactions\Settings\Teams\AddTeamMember',
            'Contracts\Interactions\Settings\Teams\UpdateTeamMember' => 'Interactions\Settings\Teams\UpdateTeamMember',
            'Contracts\Interactions\Settings\Teams\UpdateTeamPhoto' => 'Interactions\Settings\Teams\UpdateTeamPhoto',
            'Contracts\Interactions\Settings\Teams\SendInvitation' => 'Interactions\Settings\Teams\SendInvitation',
            'Contracts\Interactions\Settings\Security\EnableTwoFactorAuth' => 'Interactions\Settings\Security\EnableTwoFactorAuthUsingAuthy',
            'Contracts\Interactions\Settings\Security\VerifyTwoFactorAuthToken' => 'Interactions\Settings\Security\VerifyTwoFactorAuthTokenUsingAuthy',
            'Contracts\Interactions\Settings\Security\DisableTwoFactorAuth' => 'Interactions\Settings\Security\DisableTwoFactorAuthUsingAuthy',
            'Contracts\Interactions\Settings\PaymentMethod\UpdatePaymentMethod' => 'Interactions\Settings\PaymentMethod\UpdateStripePaymentMethod',
            'Contracts\Interactions\Settings\PaymentMethod\RedeemCoupon' => 'Interactions\Settings\PaymentMethod\RedeemStripeCoupon',
        ];

        foreach ($services as $key => $value) {
            $this->app->singleton('Laravel\Spark\\'.$key, 'Laravel\Spark\\'.$value);
        }
    }

    /**
     * Register the Authy service.
     *
     * @return void
     */
    protected function registerAuthyService()
    {
        $this->app->when('Laravel\Spark\Services\Security\Authy')
                ->needs('$key')
                ->give(function () {
                    return config('services.authy.secret');
                });
    }

    /**
     * Register the Intervention image manager binding.
     *
     * @return void
     */
    protected function registerInterventionService()
    {
        $this->app->bind(ImageManager::class, function () {
            return new ImageManager(['driver' => 'gd']);
        });
    }

    /**
     * Register the Api Token repository.
     *
     * @return void
     */
    private function registerApiTokenRepository()
    {
        $concrete = class_exists('Laravel\Passport\Passport')
                        ? 'Laravel\Spark\Repositories\PassportTokenRepository'
                        : 'Laravel\Spark\Repositories\TokenRepository';

        $this->app->singleton('Laravel\Spark\Contracts\Repositories\TokenRepository', $concrete);
    }
}
