<?php

namespace Laravel\Spark\Repositories;

use Laravel\Spark\Contracts\Repositories\LocalInvoiceRepository as Contract;

class StripeLocalInvoiceRepository implements Contract
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
            'total' => $invoice->rawTotal() / 100,
            'tax' => $invoice->asStripeInvoice()->tax / 100,
            'card_country' => $billable->card_country,
            'billing_state' => $billable->billing_state,
            'billing_zip' => $billable->billing_zip,
            'billing_country' => $billable->billing_country,
            'vat_id' => $billable->vat_id,
        ]);
    }
}
