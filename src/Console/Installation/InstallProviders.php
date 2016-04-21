<?php

namespace Laravel\Spark\Console\Installation;

class InstallProviders
{
    /**
     * The console command instance.
     *
     * @var \Illuminate\Console\Command  $command
     */
    protected $command;

    /**
     * Create a new installer instance.
     *
     * @param  \Illuminate\Console\Command  $command
     * @return void
     */
    public function __construct($command)
    {
        $this->command = $command;

        $this->command->line('Installing Service Providers: <info>✔</info>');
    }

    /**
     * Install the components.
     *
     * @return void
     */
    public function install()
    {
        copy(
            $this->getEventProvider(),
            app_path('Providers/EventServiceProvider.php')
        );

        copy(
            SPARK_STUB_PATH.'/app/Providers/RouteServiceProvider.php',
            app_path('Providers/RouteServiceProvider.php')
        );

        copy(
            $this->getSparkProvider(),
            $providerPath = app_path('Providers/SparkServiceProvider.php')
        );
    }

    /**
     * Get the path to the proper event service provider.
     *
     * @return string
     */
    protected function getEventProvider()
    {
        return $this->command->option('braintree')
                        ? SPARK_STUB_PATH.'/app/Providers/BraintreeEventServiceProvider.php'
                        : SPARK_STUB_PATH.'/app/Providers/EventServiceProvider.php';
    }

    /**
     * Get the path to the proper Spark service provider.
     *
     * @return string
     */
    protected function getSparkProvider()
    {
        if ($this->command->option('braintree')) {
            return $this->getBraintreeSparkProvider();
        }

        return $this->command->option('team-billing')
                        ? SPARK_STUB_PATH.'/app/Providers/SparkTeamBillingServiceProvider.php'
                        : SPARK_STUB_PATH.'/app/Providers/SparkServiceProvider.php';
    }

    /**
     * Get the path to the proper Braintree Spark service provider.
     *
     * @return string
     */
    protected function getBraintreeSparkProvider()
    {
        return $this->command->option('team-billing')
                        ? SPARK_STUB_PATH.'/app/Providers/SparkBraintreeTeamBillingServiceProvider.php'
                        : SPARK_STUB_PATH.'/app/Providers/SparkBraintreeServiceProvider.php';
    }
}
