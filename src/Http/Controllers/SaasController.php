<?php

namespace Laravel\Spark\Http\Controllers;

use Parsedown;
use Laravel\Spark\Spark;

class SaasController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('subscribed');
    }
    /**
     * Show the terms of service for the application.
     *
     * @return Response
     */
    public function dashboard()
    {
        return view('spark::saas.dashboard');
    }
}
