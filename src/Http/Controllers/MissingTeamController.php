<?php

namespace Laravel\Spark\Http\Controllers;

class MissingTeamController extends Controller
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
     * Show the missing team notice.
     *
     * @return Response
     */
    public function show()
    {
        return view('spark::missing-team');
    }
}
