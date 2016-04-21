<?php

namespace Laravel\Spark;

use Illuminate\Support\Str;
use Firebase\JWT\JWT as FirebaseJWT;

class JWT
{
    /**
     * Encode the given array as a JWT token.
     *
     * @param  array  $token
     * @return string
     */
    public static function encode($token)
    {
        return FirebaseJWT::encode($token, static::getKey());
    }

    /**
     * Decode the given token to an array.
     *
     * @param  string  $token
     * @return array
     */
    public static function decode($token)
    {
        return (array) FirebaseJWT::decode($token, static::getKey(), ['HS256']);
    }

    /**
     * Get the encryption key for the application.
     *
     * @return string
     */
    protected static function getKey()
    {
        $key = config('app.key');

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        return $key;
    }
}
