<?php

namespace Laravel\Spark\Console\Installation;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class InstallEnvironment
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

        $this->command->line('Updating Environment File: <info>✔</info>');
    }

    /**
     * Install the components.
     *
     * @return void
     */
    public function install()
    {
        if (Str::contains(file_get_contents(base_path('.env')), 'AUTHY_SECRET')) {
            return;
        }

        (new Filesystem)->append(
            base_path('.env'), file_get_contents(SPARK_STUB_PATH.'/.env')
        );
    }
}
