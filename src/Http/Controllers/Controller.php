<?php

namespace Laravel\Spark\Http\Controllers;

use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController
{
    use ValidatesRequests;

    /**
     * Execute the given interaction.
     *
     * This performs the common validate and handle flow of some interactions.
     *
     * @param  Request  $request
     * @param  string  $interaction
     * @param  array  $parameters
     * @return void
     */
    public function interaction(Request $request, $interaction, array $parameters)
    {
        Spark::interact($interaction.'@validator', $parameters)->validate();

        return Spark::interact($interaction, $parameters);
    }
}
