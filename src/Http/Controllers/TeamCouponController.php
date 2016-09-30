<?php

namespace Laravel\Spark\Http\Controllers;

use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Laravel\Spark\Contracts\Repositories\CouponRepository;

class TeamCouponController extends Controller
{
    /**
     * The coupon repository implementation.
     *
     * @var \Laravel\Spark\Contracts\Repositories\CouponRepository
     */
    protected $coupons;

    /**
     * Create a new controller instance.
     *
     * @param  \Laravel\Spark\Contracts\Repositories\CouponRepository  $coupons
     * @return void
     */
    public function __construct(CouponRepository $coupons)
    {
        $this->coupons = $coupons;

        $this->middleware('auth')->only('current');
    }

    /**
     * Get the current discount for the given team.
     *
     * @param  Request  $request
     * @param  string  $teamId
     * @return Response
     */
    public function current(Request $request, $teamId)
    {
        $team = Spark::team()->where('id', $teamId)->firstOrFail();

        if ($coupon = $this->coupons->forBillable($team)) {
            return response()->json($coupon->toArray());
        }

        abort(204);
    }
}
