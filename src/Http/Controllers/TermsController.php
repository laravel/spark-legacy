<?php

namespace Laravel\Spark\Http\Controllers;

use Parsedown;

class TermsController extends Controller
{
    /**
     * Show the terms of service for the application.
     *
     * @return Response
     */
    public function show()
    {
        return view('spark::terms', [
            'terms' => (new Parsedown)->text(file_get_contents(base_path('terms.md')))
        ]);
    }
}
