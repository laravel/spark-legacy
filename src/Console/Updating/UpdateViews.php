<?php

namespace Laravel\Spark\Console\Updating;

use Illuminate\Filesystem\Filesystem;

class UpdateViews
{
    /**
     * The console command instance.
     *
     * @var \Illuminate\Console\Command  $command
     */
    protected $command;

    /**
     * The path to the downloaded Spark upgrade.
     *
     * @var string
     */
    protected $downloadPath;

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Console\Command  $command
     * @param  string  $downloadPath
     * @return void
     */
    public function __construct($command, $downloadPath)
    {
        $this->command = $command;
        $this->downloadPath = $downloadPath;

        $this->command->line('Updating Views: <info>✔</info>');
    }

    /**
     * Update the components.
     *
     * @return void
     */
    public function update()
    {
        $this->viewsThatHaveBeenPublished()->each(function ($view) {
            if ($this->viewIsUnchanged($view) || $this->shouldOverwriteView($view)) {
                $this->updateView($view);
            }
        });

        $this->installNewViews();
    }

    /**
     * Get all of the current views for the Spark installation.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function viewsThatHaveBeenPublished()
    {
        $views = collect(
            (new Filesystem)->allFiles(SPARK_PATH.'/resources/views')
        );

        return $views->filter(function ($view) {
            return file_exists($this->publishedViewPath($view));
        });
    }

    /**
     * Publish the Spark views that exist in the download but are not published.
     *
     * @return void
     */
    protected function installNewViews()
    {
        $this->newViewsInUpdate()->each(function ($view) {
            $this->command->comment(
                '    ⇒ View ['.$this->relativeViewPath($view).'] is new. Installing...'
            );

            $this->createViewDirectoryIfNecessary($view);

            copy($view->getRealPath(), $this->publishedViewPath($view));
        });
    }

    /**
     * Get all of the current views for the Spark installation.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function newViewsInUpdate()
    {
        $views = collect(
            (new Filesystem)->allFiles($this->downloadPath.'/resources/views')
        );

        return $views->reject(function ($view) {
            return file_exists($this->publishedViewPath($view));
        });
    }

    /**
     * Create the view's directory if it doesn't exist.
     *
     * @param  \SplFileInfo  $view
     * @return void
     */
    protected function createViewDirectoryIfNecessary($view)
    {
        if (! is_dir($directory = dirname($this->publishedViewPath($view)))) {
            (new Filesystem)->makeDirectory(
                $directory, $mode = 0755, $recursive = true
            );
        }
    }

    /**
     * Determine if the given view file is unchanged.
     *
     * @param  \SplFileInfo  $view
     * @return bool
     */
    protected function viewIsUnchanged($view)
    {
        return md5_file($this->publishedViewPath($view)) ==
               md5_file($view->getRealPath());
    }

    /**
     * Update the given view.
     *
     * @param  \SplFileInfo  $view
     * @return void
     */
    protected function updateView($view)
    {
        if (! file_exists($this->downloadedViewPath($view))) {
            return;
        }

        copy(
            $this->downloadedViewPath($view),
            $this->publishedViewPath($view)
        );
    }

    /**
     * Ask the user if the given view should be overwritten.
     *
     * @param  \SplFileInfo  $view
     * @return bool
     */
    protected function shouldOverwriteView($view)
    {
        return $this->command->confirm(
            '    ⇒ View ['.$this->relativeViewPath($view).'] has been modified. Overwrite?'
        );
    }

    /**
     * Get the fully qualified path to the published view.
     *
     * @param  \SplFileInfo  $view
     * @return string
     */
    protected function publishedViewPath($view)
    {
        return resource_path(implode(DIRECTORY_SEPARATOR, ['views', 'vendor', 'spark', $this->relativeViewPath($view)]));
    }

    /**
     * Get the fully qualified path to a downloaded view.
     *
     * @param  \SplFileInfo  $view
     * @return string
     */
    protected function downloadedViewPath($view)
    {
        return implode(DIRECTORY_SEPARATOR, [$this->downloadPath, 'resources', 'views', $this->relativeViewPath($view)]);
    }

    /**
     * Get the view path relative to the views directory.
     *
     * @param  \SplFileInfo  $view
     * @return string
     */
    protected function relativeViewPath($view)
    {
        $sparkPath = implode(DIRECTORY_SEPARATOR, [SPARK_PATH, 'resources', 'views']);

        $downloadPath = implode(DIRECTORY_SEPARATOR, [$this->downloadPath, 'resources', 'views']);

        return str_replace(
            [$sparkPath.DIRECTORY_SEPARATOR, $downloadPath.DIRECTORY_SEPARATOR],
            '',
            $view->getRealPath()
        );
    }
}
