<?php

namespace Laravel\Spark\Interactions\Settings\Security;

use Laravel\Spark\Services\Security\Authy;
use Laravel\Spark\Contracts\Interactions\Settings\Security\EnableTwoFactorAuth as Contract;

class EnableTwoFactorAuthUsingAuthy implements Contract
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
    public function handle($user, $countryCode, $phoneNumber)
    {
        $user->forceFill([
            'authy_id' => $this->authy->enable(
                $user->email, $phoneNumber, $countryCode
            ),
        ])->save();

        return $user;
    }
}
