<?php

namespace Laravel\Spark\Http\Middleware;

class VerifyUserIsSubscribed
{
    /**
     * Verify the incoming request's user has a subscription.
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
                                : redirect('/settings#/subscription');
    }

    /**
     * Determine if the given user is subscribed to the given plan.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $subscription
     * @param  string  $plan
     * @param  bool  $defaultSubscription
     * @return bool
     */
    protected function subscribed($user, $subscription, $plan, $defaultSubscription)
    {
        if (! $user) {
            return false;
        }

        return ($defaultSubscription && $user->onGenericTrial()) ||
                $user->subscribed($subscription, $plan);
    }
}
