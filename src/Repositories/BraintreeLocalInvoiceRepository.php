<?php

namespace Laravel\Spark\Repositories;

use Laravel\Spark\Contracts\Repositories\LocalInvoiceRepository as Contract;

class BraintreeLocalInvoiceRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function createForUser($user, $invoice)
    {
        return $this->createForBillable($user, $invoice);
    }

    /**
     * {@inheritdoc}
     */
    public function createForTeam($team, $invoice)
    {
        return $this->createForBillable($team, $invoice);
    }

    /**
     * Create a local invoice for the given billable entity.
     *
     * @param  mixed  $billable
     * @param  \Laravel\Cashier\Invoice  $invoice
     * @return \Laravel\Spark\LocalInvoice
     */
    protected function createForBillable($billable, $invoice)
    {
        if ($existing = $billable->localInvoices()->where('provider_id', $invoice->id)->first()) {
            return $existing;
        }

        return $billable->localInvoices()->create([
            'provider_id' => $invoice->id,
            'total' => $invoice->rawTotal() - ($invoice->rawTotal() * $billable->taxPercentage()),
            'tax' => $invoice->rawTotal() * $billable->taxPercentage(),
            'card_country' => null,
            'billing_state' => null,
            'billing_zip' => null,
            'billing_country' => null,
        ]);
    }
}
