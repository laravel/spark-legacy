<?php

namespace Laravel\Spark\Http\Middleware;

class VerifyTeamOwnerIsSubscribed
{
    /**
     * Verify the incoming request's current team owner has a subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $subscription
     * @param  string  $plan
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next, $subscription = 'default', $plan = null)
    {
        if ($this->subscribed($request->user()->currentTeam->owner, $subscription, $plan, func_num_args() === 2)) {
            return $next($request);
        }
        return $request->ajax() || $request->wantsJson()
                                ? response('Subscription Required.', 402)
                                : redirect('/settings/#/subscription');
    }
    /**
     * Determine if the given user's current team owner is subscribed to the given plan.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $subscription
     * @param  bool  $plan
     * @param  bool  $defaultSubscription
     * @return bool
     */
    protected function subscribed($user, $subscription, $plan, $defaultSubscription)
    {
        if (! $user || ! $user->currentTeam->owner()) {
            return false;
        }
        return ($defaultSubscription && $user->currentTeam->owner->onGenericTrial()) ||
                $user->currentTeam->owner->subscribed($subscription, $plan);
    }
}
