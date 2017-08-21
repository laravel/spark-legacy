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
    protected $signature = 'spark:update
                            {--major : Update Spark to the latest major release.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Spark installation';

    /**
     * The target Spark major version number.
     *
     * @var string
     */
    protected $targetMajorVersion;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->targetMajorVersion = $this->option('major') ?
                        null : explode('.', Spark::$version)[0];

        if ($this->onLatestRelease()) {
            return $this->info('You are already running the latest release of Spark.');
        }

        $downloadPath = (new Updating\DownloadRelease($this))->download(
            $release = $this->latestSparkRelease($this->targetMajorVersion)
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
        return version_compare(Spark::$version, $this->latestSparkRelease($this->targetMajorVersion), '>=');
    }
}
