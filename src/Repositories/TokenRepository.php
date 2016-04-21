<?php

namespace Laravel\Spark\Repositories;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Laravel\Spark\JWT;
use Laravel\Spark\Token;
use Laravel\Spark\Contracts\Repositories\TokenRepository as Contract;

class TokenRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function validToken($token)
    {
        return Token::where('token', $token)->where(function ($query) {
            return $query->whereNull('expires_at')
                         ->orWhere('expires_at', '>=', Carbon::now());
        })->first();
    }

    /**
     * {@inheritdoc}
     */
    public function createToken($user, $name, array $data = [])
    {
        $this->deleteExpiredTokens($user);

        return $user->tokens()->create([
            'id' => Uuid::uuid4(),
            'user_id' => $user->id,
            'name' => $name,
            'token' => str_random(60),
            'metadata' => $data,
            'transient' => false,
            'expires_at' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function createTokenCookie($user)
    {
        $token = JWT::encode([
            'sub' => $user->id,
            'xsrf' => csrf_token(),
            'expiry' => Carbon::now()->addMinutes(5)->getTimestamp(),
        ]);

        return cookie(
            'spark_token', $token, 5, null,
            config('session.domain'), config('session.secure'), true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function updateToken(Token $token, $name, array $abilities = [])
    {
        $metadata = $token->metadata;

        $metadata['abilities'] = $abilities;

        $token->forceFill([
            'name' => $name,
            'metadata' => $metadata,
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
