<?php

namespace Laravel\Spark\Repositories;

use Carbon\Carbon;
use Laravel\Spark\Spark;
use Laravel\Spark\Events\PaymentMethod\VatIdUpdated;
use Laravel\Spark\Events\PaymentMethod\BillingAddressUpdated;
use Laravel\Spark\Contracts\Repositories\TeamRepository as TeamRepositoryContract;

class TeamRepository implements TeamRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Spark::team()->with('owner', 'users')->where('id', $id)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function forUser($user)
    {
        return $user->teams()->with('owner')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function create($user, array $data)
    {
        $attributes = [
            'owner_id' => $user->id,
            'name' => $data['name'],
            'trial_ends_at' => Carbon::now()->addDays(Spark::teamTrialDays()),
        ];

        if (Spark::teamsIdentifiedByPath()) {
            $attributes['slug'] = $data['slug'];
        }

        return Spark::team()->forceCreate($attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function updateBillingAddress($team, array $data)
    {
        $team->forceFill([
            'card_country' => array_get($data, 'card_country'),
            'billing_address' => array_get($data, 'address'),
            'billing_address_line_2' => array_get($data, 'address_line_2'),
            'billing_city' => array_get($data, 'city'),
            'billing_state' => array_get($data, 'state'),
            'billing_zip' => array_get($data, 'zip'),
            'billing_country' => array_get($data, 'country'),
        ])->save();

        event(new BillingAddressUpdated($team));
    }

    /**
     * {@inheritdoc}
     */
    public function updateVatId($team, $vatId)
    {
        $team->forceFill(['vat_id' => $vatId])->save();

        event(new VatIdUpdated($team));
    }
}
