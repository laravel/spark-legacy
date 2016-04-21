<?php

namespace Laravel\Spark\Contracts\Interactions\Support;

interface SendSupportEmail
{
    /**
     * Get a validator instance for the given data.
     *
     * @param  array  $data
     * @return \Illuminate\Validation\Validator
     */
    public function validator(array $data);

    /**
     * Send a customer support e-mail.
     *
     * @param  array  $data
     * @return void
     */
    public function handle(array $data);
}
