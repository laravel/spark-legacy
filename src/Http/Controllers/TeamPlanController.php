<?php

namespace Laravel\Spark\Http\Controllers;

use Laravel\Spark\Spark;

class TeamPlanController extends Controller
{
    /**
     * Get the all of the team plans defined for the appliation.
     *
     * @return Response
     */
    public function all()
    {
        return response()->json(Spark::teamPlans());
    }
}
