<?php

namespace Laravel\Spark\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Spark\Console\Installation;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spark:install
                    {--braintree : Install Braintree versions of the file stubs}
                    {--team-billing : Configure Spark for team based billing}
                    {--force : Force Spark to install even it has been already installed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Spark scaffolding into the application';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! defined('SPARK_STUB_PATH')) {
            define('SPARK_STUB_PATH', SPARK_PATH.'/install-stubs');
        }

        if ($this->sparkAlreadyInstalled() && ! $this->option('force')) {
            return $this->line('Spark is already installed for this project.');
        }

        $installers = collect([
            Installation\InstallConfiguration::class,
            Installation\InstallEnvironment::class,
            Installation\InstallHttp::class,
            Installation\InstallImages::class,
            Installation\InstallMigrations::class,
            Installation\InstallModels::class,
            Installation\InstallProviders::class,
            Installation\InstallResources::class,
        ]);

        $installers->each(function ($installer) { (new $installer($this))->install(); });

        $this->comment('Laravel Spark installed. Create something amazing!');
    }

    /**
     * Determine if Spark is already installed.
     *
     * @return bool
     */
    protected function sparkAlreadyInstalled()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        return isset($composer['require']['laravel/spark']);
    }
}
