<?php

namespace Laravel\Spark;

use GuzzleHttp\Client as HttpClient;

trait InteractsWithSparkApi
{
    /**
     * Get the latest Spark release version.
     *
     * @return string
     */
    protected function latestSparkRelease()
    {
        return json_decode((string) (new HttpClient)->get(
            $this->sparkUrl.'/api/releases/version'
        )->getBody())->version;
    }

    /**
     * The Spark base URL.
     *
     * @var string
     */
    protected $sparkUrl = 'https://spark.laravel.com';
}
