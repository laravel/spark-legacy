<?php

namespace Laravel\Spark\Interactions\Settings\Security;

use Laravel\Spark\Services\Security\Authy;
use Laravel\Spark\Contracts\Interactions\Settings\Security\VerifyTwoFactorAuthToken as Contract;

class VerifyTwoFactorAuthTokenUsingAuthy implements Contract
{
    /**
     * The Authy service instance.
     *
     * @var \Laravel\Spark\Services\Security\Authy
     */
    protected $authy;

    /**
     * Create a new interaction instance.
     *
     * @param  \Laravel\Spark\Services\Security\Authy  $authy
     * @return void
     */
    public function __construct(Authy $authy)
    {
        $this->authy = $authy;
    }

    /**
     * {@inheritdoc}
     */
    public function handle($user, $token)
    {
        return $this->authy->verify($user->authy_id, $token);
    }
}
