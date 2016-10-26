<?php

namespace Laravel\Spark\Repositories;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Laravel\Spark\JWT;
use Laravel\Spark\Token;
use Laravel\Passport\Passport;
use Laravel\Passport\Token as PassportToken;
use Laravel\Spark\Contracts\Repositories\TokenRepository as Contract;

class PassportTokenRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function all($user)
    {
        return $user->tokens()
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($token) {
                        return new Token([
                            'id' => $token->id,
                            'name' => $token->name,
                            'metadata' => ['abilities' => $token->scopes],
                        ]);
                    });
    }

    /**
     * {@inheritdoc}
     */
    public function validToken($token)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function createToken($user, $name, array $data = [])
    {
        $this->deleteExpiredTokens($user);

        $scopes = isset($data['abilities']) ? $data['abilities'] : [];

        return new Token([
            'token' => $user->createToken($name, $scopes)->accessToken
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function createTokenCookie($user)
    {
        $token = JWT::encode([
            'sub' => $user->id,
            'csrf' => csrf_token(),
            'expiry' => Carbon::now()->addMinutes(5)->getTimestamp(),
        ]);

        return cookie(
            Passport::cookie(), $token, 5, null,
            config('session.domain'), config('session.secure'), true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function updateToken(Token $token, $name, array $abilities = [])
    {
        $token = PassportToken::findOrFail($token->id);

        $token->forceFill([
            'name' => $name,
            'scopes' => $abilities,
        ])->save();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteExpiredTokens($user)
    {
        $user->tokens()->where('expires_at', '<=', Carbon::now())->delete();
    }
}
