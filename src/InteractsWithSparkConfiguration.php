<?php

namespace Laravel\Spark;

use Exception;

trait InteractsWithSparkConfiguration
{
    /**
     * Get the Spark API token from the configuration file.
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function readToken()
    {
        if (! $this->configExists()) {
            throw new Exception("Spark configuration file not found. Please register a token.");
        }

        return json_decode(
            file_get_contents($this->configPath()), true
        )['token'];
    }

    /**
     * Write the Spark token to the configuration.
     *
     * @param  string  $token
     * @return void
     */
    protected function storeToken($token)
    {
        file_put_contents($this->configPath(), json_encode([
            'token' => $token
        ], JSON_PRETTY_PRINT).PHP_EOL);
    }

    /**
     * Determine if the Spark configuration file exists.
     *
     * @return bool
     */
    protected function configExists()
    {
        return file_exists($this->configPath());
    }

    /**
     * Get the Spark configuration file path.
     *
     * @return string
     */
    protected function configPath()
    {
        return $_SERVER['HOME'].'/.spark/config.json';
    }
}
