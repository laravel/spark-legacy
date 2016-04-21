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
     * @return bool
     */
    public function validate($attribute, $value, $parameters)
    {
        if (empty($parameters)) {
            return true;
        }

        $abbreviations = $this->states->forCountry($parameters[0])
                                ->pluck('abbreviation')->all();

        return empty($abbreviations) || in_array($value, $abbreviations);
    }
}
