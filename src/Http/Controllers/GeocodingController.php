<?php

namespace Laravel\Spark\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client as HttpClient;
use Laravel\Spark\Contracts\Repositories\Geography\StateRepository;

class GeocodingController extends Controller
{
    /**
     * Attempt to gather the current user's country via Geocoding.
     *
     * @param  Request  $request
     * @return Response
     */
    public function country(Request $request)
    {
        try {
            $response = (new HttpClient)->get('http://ip2c.org/?ip='.$request->ip());

            $body = (string) $response->getBody();

            if ($body[0] === '1') {
                return explode(';', $body)[1];
            }
        } catch (Exception $e) {
            return response('', 404);
        }
    }

    /**
     * Get the states / provinces for a given country code.
     *
     * @param  string  $country
     * @return Response
     */
    public function states($country)
    {
        return response()->json(app(StateRepository::class)->forCountry($country)->all());
    }
}
