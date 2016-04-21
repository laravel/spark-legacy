<?php

namespace Laravel\Spark;

use Illuminate\Database\Eloquent\Model;

class LocalInvoice extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoices';

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
    protected $hidden = [];

    /**
     * Get the user that owns the invoice.
     */
    public function user()
    {
        return $this->belongsTo(Spark::userModel(), 'user_id');
    }
}
