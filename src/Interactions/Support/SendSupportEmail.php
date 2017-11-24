<?php

namespace Laravel\Spark\Interactions\Support;

use RuntimeException;
use Laravel\Spark\Spark;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Spark\Contracts\Interactions\Support\SendSupportEmail as Contract;

class SendSupportEmail implements Contract
{
    /**
     * Get a validator instance for the given data.
     *
     * @param  array  $data
     * @return \Illuminate\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'from' => 'required',
            'subject' => 'required|max:2048',
            'message' => 'required',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(array $data)
    {
        if (! Spark::hasSupportAddress()) {
            throw new RuntimeException(__("No customer support request recipient is defined."));
        }

        Mail::raw($data['message'], function ($m) use ($data) {
            $m->to(Spark::supportAddress())->subject(__('Support Request: ').$data['subject']);

            $m->replyTo($data['from']);
        });
    }
}
