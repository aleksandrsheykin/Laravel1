<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'vk_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function getCategories()
	{
		return $this->hasMany('Category');
	}

	public function getCash()
	{
		return $this->hasMany('Cash');
	}

	public function getMovements()
	{
		return $this->hasMany('Movement');
	}

	public function getBalances()
	{
		return $this->hasMany('Balance');
	}

	public function getDescriptionDay()
	{
		return $this->hasMany('DescriptionDay');
	}	
}
