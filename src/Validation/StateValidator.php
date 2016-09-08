<?php

namespace Laravel\Spark\Validation;

use Laravel\Spark\Contracts\Repositories\Geography\StateRepository;

class StateValidator
{
    /**
     * The state repository implementation.
     *
     * @var StateRepository
     */
    protected $states;

    /**
     * Create a new state validator instance.
     *
     * @param  StateRepository  $states
     * @return void
     */
    public function __construct(StateRepository $states)
    {
        $this->states = $states;
    }

    /**
     * Validate the given data.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array  $parameters
     * @return bool
     */
    public function validate($attribute, $value, $parameters)
    {
        if (empty($parameters)) {
            return true;
        }

        $states = $this->states->forCountry($parameters[0])->flatten()->map(function ($item, $key) {
            return strtoupper($item);
        })->all();

        return empty($states) || in_array(strtoupper($value), $states);
    }
}
