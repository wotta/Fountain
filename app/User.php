<?php

namespace App;

use Darovi\Gravatar;
use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Gravatar, Billable, Notifiable;
	
	/**
     * Column gravatar uses to generate the users image
     *
     * @return string
     */
    protected function emailAttributeName()
    {
       return 'email';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
