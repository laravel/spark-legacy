<?php

namespace Laravel\Spark\Http\Middleware;

use Laravel\Spark\Spark;

class VerifyUserIsDeveloper
{
    /**
     * Determine if the authenticated user is a developer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        if ($request->user() && Spark::developer($request->user()->email)) {
            return $next($request);
        }

        return $request->ajax() || $request->wantsJson()
                        ? response('Unauthorized.', 401)
                        : redirect()->guest('login');
    }
}
