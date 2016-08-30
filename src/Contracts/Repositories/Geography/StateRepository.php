<?php

namespace Laravel\Spark\Contracts\Repositories\Geography;

interface StateRepository
{
    /**
     * Get a comma delimited list of abbreviation for the given country.
     *
     * @param  string  $country
     * @return string
     */
    public function abbreviationListForCountry($country);

    /**
     * Get all of the states / provinces for the given 2-letter country code.
     *
     * @param  string  $country
     * @return \Illuminate\Support\Collection
     */
    public function forCountry($country);
}
