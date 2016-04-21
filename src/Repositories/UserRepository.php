<?php

namespace Laravel\Spark\Repositories;

use Carbon\Carbon;
use Laravel\Spark\Spark;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Events\PaymentMethod\VatIdUpdated;
use Laravel\Spark\Events\PaymentMethod\BillingAddressUpdated;
use Laravel\Spark\Contracts\Repositories\UserRepository as UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    /**
     * {@inheritdoc}
     */
    public function current()
    {
        if (Auth::check()) {
            return $this->find(Auth::id())->shouldHaveSelfVisibility();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $user = Spark::user()->where('id', $id)->first();

        return $user ? $this->loadUserRelationships($user) : null;
    }

    /**
     * Load the relationships for the given user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function loadUserRelationships($user)
    {
        $user->load('subscriptions');

        if (Spark::usesTeams()) {
            $user->load(['ownedTeams.subscriptions', 'teams.subscriptions']);

            $user->currentTeam();
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function search($query, $excludeUser = null)
    {
        $search = Spark::user()->with('subscriptions');

        // If a user to exclude was passed to the repository, we will exclude their User
        // ID from the list. Typically we don't want to show the current user in the
        // search results and only want to display the other users from the query.
        if ($excludeUser) {
            $search->where('id', '<>', $excludeUser->id);
        }

        return $search->where(function ($search) use ($query) {
            $search->where('email', 'like', $query)
                   ->orWhere('name', 'like', $query);
        })->get();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $user = Spark::user();

        $user->forceFill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'last_read_announcements_at' => Carbon::now(),
            'trial_ends_at' => Carbon::now()->addDays(Spark::trialDays()),
        ])->save();

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function updateBillingAddress($user, array $data)
    {
        $user->forceFill([
            'card_country' => array_get($data, 'card_country'),
            'billing_address' => array_get($data, 'address'),
            'billing_address_line_2' => array_get($data, 'address_line_2'),
            'billing_city' => array_get($data, 'city'),
            'billing_state' => array_get($data, 'state'),
            'billing_zip' => array_get($data, 'zip'),
            'billing_country' => array_get($data, 'country'),
        ])->save();

        event(new BillingAddressUpdated($user));
    }

    /**
     * {@inheritdoc}
     */
    public function updateVatId($user, $vatId)
    {
        $user->forceFill(['vat_id' => $vatId])->save();

        event(new VatIdUpdated($user));
    }
}
