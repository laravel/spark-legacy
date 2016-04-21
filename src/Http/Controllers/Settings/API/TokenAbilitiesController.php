<?php

namespace Laravel\Spark\Http\Controllers\Settings\API;

use Laravel\Spark\Spark;
use Laravel\Spark\Http\Controllers\Controller;

class TokenAbilitiesController extends Controller
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
     * Get all of the available token abilities.
     *
     * @return Response
     */
    public function all()
    {
        return response()->json(collect(Spark::tokensCan())->map(function ($value, $key) {
            return [
                'name' => $value,
                'value' => $key,
                'default' => in_array($key, Spark::tokenDefaults())
            ];
        })->values());
    }
}
