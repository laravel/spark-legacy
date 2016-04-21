<?php

namespace Laravel\Spark\Http\Controllers;

use Laravel\Spark\Spark;

class PlanController extends Controller
{
    /**
     * Get the all of the plans defined for the appliation.
     *
     * @return Response
     */
    public function all()
    {
        return response()->json(Spark::plans());
    }
}
