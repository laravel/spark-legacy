<?php

namespace Laravel\Spark\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Spark\Console\Updating;

class UpdateViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spark:update-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Spark views';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $updaters = collect([
            Updating\UpdateViews::class,
        ]);

        $updaters->each(function ($updater) {
            (new $updater($this, SPARK_PATH))->update();
        });
    }
}
