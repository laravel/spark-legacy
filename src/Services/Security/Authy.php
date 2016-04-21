<?php

namespace Laravel\Spark\Services\Security;

use Exception;
use GuzzleHttp\Client as HttpClient;

class Authy
{
    /**
     * The Authy API key.
     *
     * @var string
     */
    protected $key;

    /**
     * Create a new Authy instance.
     *
     * @param  string  $key
     * @return void
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Enable two-factor authentication for a given number.
     *
     * @param  string  $email
     * @param  string  $phoneNumber
     * @param  string  $countryCode
     * @return string
     */
    public function enable($email, $phoneNumber, $countryCode)
    {
        $url = 'https://api.authy.com/protected/json/users/new?api_key='.$this->key;

        $response = json_decode((new HttpClient)->post($url, [
            'form_params' => [
                'user' => [
                    'email' => $email,
                    'cellphone' => $phoneNumber,
                    'country_code' => $countryCode,
                ],
            ],
        ])->getBody(), true);

        return $response['user']['id'];
    }

    /**
     * Disable two-factor authentication for the user.
     *
     * @param  string  $authyId
     * @return string
     */
    public function disable($authyId)
    {
        (new HttpClient)->post(
            'https://api.authy.com/protected/json/users/delete/'.$authyId.'?api_key='.$this->key
        );
    }

    /**
     * Verify that the given token is valid for the user.
     *
     * @param  string  $authyId
     * @param  string  $token
     * @return bool
     */
    public function verify($authyId, $token)
    {
        try {
            $response = json_decode((new HttpClient)->get(
                'https://api.authy.com/protected/json/verify/'.$token.'/'.$authyId.'?force=true&api_key='.$this->key
            )->getBody(), true);

            return $response['token'] === 'is valid';
        } catch (Exception $e) {
            return false;
        }
    }
}
