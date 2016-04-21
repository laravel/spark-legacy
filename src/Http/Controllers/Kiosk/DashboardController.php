<?php

namespace Laravel\Spark\Http\Controllers\Kiosk;

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
        $this->middleware('dev');
    }

    /**
     * Show the kiosk dashboard.
     *
     * @return Response
     */
    public function show()
    {
        return view('spark::kiosk');
    }
}
