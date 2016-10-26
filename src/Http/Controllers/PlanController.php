<?php

namespace Laravel\Spark\Http\Controllers;

use Laravel\Spark\Spark;

class PlanController extends Controller
{
    /**
     * Get the all of the regular plans defined for the application.
     *
     * @return Response
     */
    public function all()
    {
        return response()->json(Spark::plans()->merge(Spark::teamPlans()));
    }
}
