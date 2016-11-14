<?php

namespace Laravel\Spark\Console\Commands;

use Laravel\Spark\Spark;
use Illuminate\Console\Command;
use Laravel\Spark\Console\Updating;
use Laravel\Spark\InteractsWithSparkApi;

class UpdateCommand extends Command
{
    use InteractsWithSparkApi;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spark:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Spark installation';

    /**
     * The major version number of the current Spark installation.
     *
     * @var string
     */
    protected $sparkMajorVersion;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sparkMajorVersion = explode('.', Spark::$version)[0];

        if ($this->onLatestRelease()) {
            return $this->info('You are already running the latest release of Spark.');
        }

        $downloadPath = (new Updating\DownloadRelease($this))->download(
            $release = $this->latestSparkRelease($this->sparkMajorVersion)
        );

        $updaters = collect([
            Updating\UpdateViews::class,
            Updating\UpdateInstallation::class,
            Updating\RemoveDownloadPath::class,
        ]);

        $updaters->each(function ($updater) use ($downloadPath) {
            (new $updater($this, $downloadPath))->update();
        });

        $this->info('You are now running on Spark v'.$release.'. Enjoy!');
    }

    /**
     * Determine if the application is already on the latest version.
     *
     * @return bool
     */
    protected function onLatestRelease()
    {
        return version_compare(Spark::$version, $this->latestSparkRelease($this->sparkMajorVersion), '>=');
    }
}
