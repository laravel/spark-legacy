<?php

namespace Laravel\Spark\Console\Installation;

use Illuminate\Filesystem\Filesystem;

class InstallHttp
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

        $this->command->line('Updating Routes File: <info>✔</info>');
        $this->command->line('Updating Controllers: <info>✔</info>');
        $this->command->line('Updating Middleware: <info>✔</info>');
        $this->command->line('Updating HTTP Kernel: <info>✔</info>');
    }

    /**
     * Install the components.
     *
     * @return void
     */
    public function install()
    {
        (new Filesystem)->copyDirectory(SPARK_STUB_PATH.'/app/Http', app_path('Http'));

        (new Filesystem)->copyDirectory(SPARK_STUB_PATH.'/routes', base_path('routes'));
    }
}
