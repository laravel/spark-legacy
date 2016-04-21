<?php

namespace Laravel\Spark\Exceptions;

use Exception;

class IneligibleForPlan extends Exception
{
    /**
     * Create a new exception for the given reason.
     *
     * @param  string  $reason
     * @return static
     */
    public static function because($reason)
    {
        return new static($reason);
    }
}
