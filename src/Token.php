<?php

namespace Laravel\Spark;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_tokens';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
        'transient' => 'boolean',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that the token belongs to.
     */
    public function user()
    {
        return $this->belongsTo(Spark::userModel(), 'user_id');
    }

    /**
     * Determine if the token has an embedded XSRF token.
     *
     * @return bool
     */
    public function hasXsrf()
    {
        return ! empty($this->xsrf());
    }

    /**
     * Get the embedded XSRF token.
     *
     * @return string|null
     */
    public function xsrf()
    {
        return $this->data('xsrf');
    }

    /**
     * Get a piece of payload data from the token.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function data($key, $default = null)
    {
        return Arr::get($this->metadata, $key, $default);
    }

    /**
     * Determine if the token has a given permission.
     *
     * @param  string  $permission
     * @return bool
     */
    public function can($permission)
    {
        if ($this->transient) {
            return true;
        }

        return array_key_exists($permission, array_flip($this->data('abilities', [])));
    }

    /**
     * Determine if the token does not have a given permission.
     *
     * @param  string  $permission
     * @return bool
     */
    public function cant($permission)
    {
        return ! $this->can($permission);
    }

    /**
     * Update the last used timestamp for the token.
     *
     * @return void
     */
    public function touchLastUsedTimestamp()
    {
        if ($this->transient) {
            return;
        }

        $this->last_used_at = Carbon::now();

        $this->save();
    }


    /**
     * Determine if the token is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return Carbon::now()->gte($this->expires_at);
    }
}
