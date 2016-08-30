<?php

namespace Laravel\Spark\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Spark\Contracts\Repositories\TokenRepository;

class TokenController extends Controller
{
    /**
     * The token repository instance.
     *
     * @var TokenRepository
     */
    protected $tokens;

    /**
     * Create a new controller instance.
     *
     * @param  TokenRepository  $tokens
     * @return void
     */
    public function __construct(TokenRepository $tokens)
    {
        $this->tokens = $tokens;

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
        $this->tokens->deleteExpiredTokens($request->user());

        return response('Refreshed.')->withCookie(
            $this->tokens->createTokenCookie($request->user())
        );
    }
}
