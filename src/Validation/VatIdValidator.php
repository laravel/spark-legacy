<?php

namespace Laravel\Spark\Validation;

use Exception;
use Mpociot\VatCalculator\VatCalculator;

class VatIdValidator
{
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
        try {
            return (new VatCalculator)->isValidVATNumber($value);
        } catch (Exception $e) {
            return false;
        }
    }
}
