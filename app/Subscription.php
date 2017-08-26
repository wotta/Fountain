<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model  {

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'stripe_id', 'stripe_plan', 'quantity', 'trial_ends_at', 'ends_at', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['trial_ends_at', 'ends_at', 'created_at', 'updated_at'];

}