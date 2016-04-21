<?php

namespace Laravel\Spark\Console\Installation;

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;

class InstallMigrations
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

        $this->command->line('Installing Database Migrations: <info>✔</info>');
    }

    /**
     * Install the components.
     *
     * @return void
     */
    public function install()
    {
        (new Filesystem)->cleanDirectory(database_path('migrations'));

        $date = Carbon::now();

        foreach ($this->getMigrations() as $key => $migration) {
            $name = $this->formatName($migration);

            // When installing the migrations, we will add a number of seconds to the current time
            // so we will install the migrations in the proper sequence when we put them in the
            // application's own database directory for consumption by an actual application.
            $timestamp = $date->addSeconds($key)
                                ->format('Y_m_d_His');

            copy(
                SPARK_STUB_PATH.'/database/'.$migration.'.php',
                database_path('migrations/'.$timestamp.'_'.$name.'.php')
            );
        }
    }

    /**
     * Format the migration name.
     *
     * @param  string  $migration
     * @return string
     */
    protected function formatName($migration)
    {
        return str_replace(
            ['migrations/braintree/', 'migrations/'], '', $migration
        );
    }

    /**
     * Get the appropriate migration files.
     *
     * @return array
     */
    protected function getMigrations()
    {
        return $this->command->option('braintree')
                        ? $this->getBraintreeMigrations()
                        : $this->getStripeMigrations();
    }

    /**
     * Get the Stripe migration files.
     *
     * @return array
     */
    protected function getStripeMigrations()
    {
        return [
            'migrations/create_performance_indicators_table',
            'migrations/create_announcements_table',
            'migrations/create_users_table',
            'migrations/create_password_resets_table',
            'migrations/create_api_tokens_table',
            'migrations/create_subscriptions_table',
            'migrations/create_invoices_table',
            'migrations/create_notifications_table',
            'migrations/create_teams_table',
            'migrations/create_team_users_table',
            'migrations/create_invitations_table',
        ];
    }

    /**
     * Get the Braintree migration files.
     *
     * @return array
     */
    protected function getBraintreeMigrations()
    {
        return [
            'migrations/create_performance_indicators_table',
            'migrations/create_announcements_table',
            'migrations/braintree/create_users_table',
            'migrations/create_password_resets_table',
            'migrations/create_api_tokens_table',
            'migrations/braintree/create_subscriptions_table',
            'migrations/create_invoices_table',
            'migrations/create_notifications_table',
            'migrations/braintree/create_teams_table',
            'migrations/create_team_users_table',
            'migrations/create_invitations_table',
        ];
    }
}
