<?php

namespace Laravel\Spark\Http\Controllers\Settings\Subscription;

use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Contracts\Interactions\Subscribe;
use Laravel\Spark\Events\Subscription\SubscriptionUpdated;
use Laravel\Spark\Events\Subscription\SubscriptionCancelled;
use Laravel\Spark\Http\Requests\Settings\Subscription\UpdateSubscriptionRequest;
use Laravel\Spark\Contracts\Http\Requests\Settings\Subscription\CreateSubscriptionRequest;

class PlanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create the subscription for the user.
     *
     * @param  CreateSubscriptionRequest  $request
     * @return Response
     */
    public function store(CreateSubscriptionRequest $request)
    {
        $plan = Spark::plans()->where('id', $request->plan)->first();

        Spark::interact(Subscribe::class, [
            $request->user(), $plan, false, $request->all()
        ]);
    }

    /**
     * Update the subscription for the user.
     *
     * @param  \Laravel\Spark\Http\Requests\Settings\Subscription\UpdateSubscriptionRequest  $request
     * @return Response
     */
    public function update(UpdateSubscriptionRequest $request)
    {
        $plan = Spark::plans()->where('id', $request->plan)->first();

        // This method is used both for updating subscriptions and for resuming cancelled
        // subscriptions that are still within their grace periods as this swap method
        // will be used for either of these situations without causing any problems.
        if ($plan->price === 0) {
            return $this->destroy($request);
        } else {
            $request->user()
                    ->subscription()
                    ->swap($request->plan);
        }

        event(new SubscriptionUpdated(
            $request->user()->fresh()
        ));
    }

    /**
     * Cancel the user's subscription.
     *
     * @param  Request  $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $request->user()->subscription()->cancel();

        event(new SubscriptionCancelled($request->user()->fresh()));
    }
}
