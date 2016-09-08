<?php

namespace Laravel\Spark\Http\Controllers\Settings\Billing;

use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Laravel\Spark\Http\Controllers\Controller;

class InvoiceController extends Controller
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
     * Get all of the invoices for the current user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function all(Request $request)
    {
        if (! $request->user()->hasBillingProvider()) {
            return [];
        }

        return $request->user()->localInvoices;
    }

    /**
     * Download the invoice with the given ID.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function download(Request $request, $id)
    {
        $invoice = $request->user()->localInvoices()
                            ->where('id', $id)->firstOrFail();

        return $request->user()->downloadInvoice(
            $invoice->provider_id, ['id' => $invoice->id] + Spark::invoiceDataFor($request->user())
        );
    }
}
