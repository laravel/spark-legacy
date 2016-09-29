<?php

namespace Laravel\Spark\Http\Middleware;

use Laravel\Spark\Spark;

class VerifyTeamIsSubscribed
{
    /**
     * Verify the incoming request's current team has a subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $subscription
     * @param  string  $plan
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next, $subscription = 'default', $plan = null)
    {
        if ($this->subscribed($request->user(), $subscription, $plan, func_num_args() === 2)) {
            return $next($request);
        }

        return $request->ajax() || $request->wantsJson()
                                ? response('Subscription Required.', 402)
                                : redirect('/settings/'.str_plural(Spark::teamString()).'/'.$request->user()->currentTeam->id.'#/subscription');
    }

    /**
     * Determine if the given user's current team is subscribed to the given plan.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $subscription
     * @param  bool  $plan
     * @param  bool  $defaultSubscription
     * @return bool
     */
    protected function subscribed($user, $subscription, $plan, $defaultSubscription)
    {
        if (! $user || ! $user->currentTeam) {
            return false;
        }

        return ($defaultSubscription && $user->currentTeam->onGenericTrial()) ||
                $user->currentTeam->subscribed($subscription, $plan);
    }
}
