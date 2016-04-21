<?php

namespace Laravel\Spark\Contracts\Repositories;

interface LocalInvoiceRepository
{
    /**
     * Create a local invoice record for the given user and provider invoice.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Laravel\Cashier\Invoice  $invoice
     * @return \Laravel\Spark\LocalInvoice
     */
    public function createForUser($user, $invoice);

    /**
     * Create a local invoice record for the given team and provider invoice.
     *
     * @param  \Laravel\Spark\Team  $team
     * @param  \Laravel\Cashier\Invoice  $invoice
     * @return \Laravel\Spark\LocalInvoice
     */
    public function createForTeam($team, $invoice);
}
