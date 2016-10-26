<?php

namespace Laravel\Spark;

use JsonSerializable;

class Plan implements JsonSerializable
{
    /**
     * The plan's Stripe ID.
     *
     * @var string
     */
    public $id;

    /**
     * The plan's displayable name.
     *
     * @var string
     */
    public $name;

    /**
     * The plan's price.
     *
     * @var integer
     */
    public $price = 0;

    /**
     * The plan's interval.
     *
     * @var string
     */
    public $interval = 'monthly';

    /**
     * The number of trial days that come with the plan.
     *
     * @var int
     */
    public $trialDays = 0;

    /**
     * The plan's features.
     *
     * @var array
     */
    public $features = [];

    /**
     * The plan's attributes.
     *
     * @var array
     */
    public $attributes = [];

    /**
     * Indicates if the plan is active.
     *
     * @var bool
     */
    public $active = true;

    /**
     * The style of the plan.
     *
     * @var string
     */
    public $type = 'user';

    /**
     * Create a new plan instance.
     *
     * @param  string  $name
     * @param  string  $id
     * @return void
     */
    public function __construct($name, $id)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Set the price of the plan.
     *
     * @param  string|integer  $price
     * @return $this
     */
    public function price($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Specify that the plan is on a yearly interval.
     *
     * @return $this
     */
    public function yearly()
    {
        $this->interval = 'yearly';

        return $this;
    }

    /**
     * Specify the number of trial days that come with the plan.
     *
     * @param  int  $trialDays
     * @return $this
     */
    public function trialDays($trialDays)
    {
        $this->trialDays = $trialDays;

        return $this;
    }

    /**
     * Specify the plan's features.
     *
     * @param  array  $features
     * @return $this
     */
    public function features(array $features)
    {
        $this->features = $features;

        return $this;
    }

    /**
     * Get a given attribute from the plan.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function attribute($key, $default = null)
    {
        return array_get($this->attributes, $key, $default);
    }

    /**
     * Set the maximum number of teams that can be owned for this plan.
     *
     * @param  int  $max
     * @return $this
     */
    public function maxTeams($max)
    {
        return $this->attributes(['teams' => $max]);
    }

    /**
     * Set the maximum number of total collaborators an account may have.
     *
     * @param  int  $max
     * @return $this
     */
    public function maxCollaborators($max)
    {
        return $this->attributes(['collaborators' => $max]);
    }

    /**
     * Set the maximum number of team members that a team may have.
     *
     * @param  int  $max
     * @return $this
     */
    public function maxTeamMembers($max)
    {
        return $this->attributes(['teamMembers' => $max]);
    }

    /**
     * Specify the plan's attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function attributes(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    /**
     * Indicate that the plan should be archived.
     *
     * @return bool
     */
    public function archived()
    {
        $this->active = false;

        return $this;
    }

    /**
     * Get the array form of the plan for serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'trialDays' => $this->trialDays,
            'interval' => $this->interval,
            'features' => $this->features,
            'active' => $this->active,
            'attributes' => $this->attributes,
            'type' => $this->type,
        ];
    }

    /**
     * Dynamically access the plan's attributes.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->attribute($key);
    }
}
