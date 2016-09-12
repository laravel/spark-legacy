<?php

namespace Laravel\Spark\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\ApiTokenCookieFactory;

class TokenController extends Controller
{
    /**
     * The API token cookie factory instance.
     *
     * @var ApiTokenCookieFactory
     */
    protected $cookieFactory;

    /**
     * Create a new controller instance.
     *
     * @param  ApiTokenCookieFactory  $cookieFactory
     * @return void
     */
    public function __construct(ApiTokenCookieFactory $cookieFactory)
    {
        $this->cookieFactory = $cookieFactory;

        $this->middleware('auth');
    }

    /**
     * Exchange the current transient API token for a new one.
     *
     * @param  Request  $request
     * @return Response
     */
    public function refresh(Request $request)
    {
        return response('Refreshed.')->withCookie($this->cookieFactory->make(
            $request->user()->getKey(), $request->session()->token()
        ));
    }
}
