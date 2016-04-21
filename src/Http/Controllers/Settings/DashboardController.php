<?php

namespace Laravel\Spark\Http\Controllers\Settings;

use Laravel\Spark\Http\Controllers\Controller;

class DashboardController extends Controller
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
     * Show the settings dashboard.
     *
     * @return Response
     */
    public function show()
    {
        return view('spark::settings');
    }
}
