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
        $termsFile = file_exists(base_path('terms.'.app()->getLocale().'.md')) ? base_path('terms.'.app()->getLocale().'.md') : base_path('terms.md');

        return view('spark::terms', [
            'terms' => (new Parsedown)->text(file_get_contents($termsFile))
        ]);
    }
}
