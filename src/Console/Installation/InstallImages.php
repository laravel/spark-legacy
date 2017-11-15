<?php

namespace Laravel\Spark\Console\Installation;

use Illuminate\Filesystem\Filesystem;

class InstallImages
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

        $this->command->line('Installing Images: <info>✔</info>');
    }

    /**
     * Install the components.
     *
     * @return void
     */
    public function install()
    {
        if (! is_dir(public_path('img'))) {
            (new Filesystem)->makeDirectory(public_path('img'));
        }

        $files = [
            SPARK_STUB_PATH.'/public/favicon.png' => public_path('favicon.png'),
            SPARK_STUB_PATH.'/public/favicon.ico' => public_path('favicon.ico'),
            SPARK_STUB_PATH.'/public/img/spark-bg.png' => public_path('img/spark-bg.png'),
            SPARK_STUB_PATH.'/public/img/mono-48px.png' => public_path('img/mono-48px.png'),
            SPARK_STUB_PATH.'/public/img/mono-logo.png' => public_path('img/mono-logo.png'),
            SPARK_STUB_PATH.'/public/img/color-logo.png' => public_path('img/color-logo.png'),
            SPARK_STUB_PATH.'/public/img/create-team.svg' => public_path('img/create-team.svg'),
        ];

        foreach ($files as $from => $to) {
            copy($from, $to);
        }
    }
}
