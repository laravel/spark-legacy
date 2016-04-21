<?php

namespace Laravel\Spark\Contracts\Repositories;

interface UserRepository
{
    /**
     * Get the current user of the application.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function current();

    /**
     * Get the user with the given ID.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function find($id);

    /**
     * Perform a basic user search by name or e-mail address.
     *
     * @param  string  $query
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $excludeUser
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($query, $excludeUser = null);

    /**
     * Create a new user with the given data.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $data);

    /**
     * Update the billing address information with the given data.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $data
     * @return void
     */
    public function updateBillingAddress($user, array $data);

    /**
     * Update the European VAT ID number for the given user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $vatId
     * @return void
     */
    public function updateVatId($user, $vatId);
}
