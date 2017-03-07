<?php

namespace Laravel\Spark;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Team extends Model
{
    use Billable, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'owner_id' => 'int',
        'trial_ends_at' => 'datetime',
    ];

    /**
     * Get the owner's email address.
     *
     * @return string
     */
    public function getEmailAttribute()
    {
        return $this->owner->email;
    }

    /**
     * Get the owner of the team.
     */
    public function owner()
    {
        return $this->belongsTo(Spark::userModel(), 'owner_id');
    }

    /**
     * Get all of the users that belong to the team.
     */
    public function users()
    {
        return $this->belongsToMany(
            Spark::userModel(), 'team_users', 'team_id', 'user_id'
        )->withPivot('role');
    }

    /**
     * Get the total number of users and pending invitations.
     *
     * @return int
     */
    public function totalPotentialUsers()
    {
        return $this->users()->count() + $this->invitations()->count();
    }

    /**
     * Get all of the team's invitations.
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Get all of the subscriptions for the team.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function subscriptions()
    {
        return $this->hasMany(TeamSubscription::class, 'team_id')->orderBy('created_at', 'desc');
    }

    /**
     * Get the available billing plans for the given entity.
     *
     * @return \Illuminate\Support\Collection
     */
    public function availablePlans()
    {
        return Spark::teamPlans();
    }

    /**
     * Get the team photo URL attribute.
     *
     * @param  string|null  $value
     * @return string|null
     */
    public function getPhotoUrlAttribute($value)
    {
        return empty($value)
                ? 'https://www.gravatar.com/avatar/'.md5($this->name.'@spark.laravel.com').'.jpg?s=200&d=identicon'
                : url($value);
    }

    /**
     * Make the team attributes visible for an owner.
     *
     * @return void
     */
    public function shouldHaveOwnerVisibility()
    {
        $this->makeVisible([
            'card_brand',
            'card_last_four',
            'card_country',
            'billing_address',
            'billing_address_line_2',
            'billing_city',
            'billing_state',
            'billing_zip',
            'billing_country',
            'extra_billing_information',
        ]);
    }

    /**
     * Detach all of the users from the team and delete the team.
     *
     * @return void
     */
    public function detachUsersAndDestroy()
    {
        if ($this->subscribed()) {
            $this->subscription()->cancelNow();
        }

        $this->users()
            ->where('current_team_id', $this->id)
            ->update(['current_team_id' => null]);

        $this->users()->detach();

        $this->delete();
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();

        $array['tax_rate'] = $this->taxPercentage();

        return $array;
    }
}
