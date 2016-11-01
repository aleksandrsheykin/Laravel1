<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Category;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'firstname', 'lastname', 'email', 'vk_id', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public static function create(array $attributes = [])		//override, copy system category for current user
	{
		$user = parent::create($attributes);
		$category = new Category();
		$categories = $category::where('is_system', '=', true)->get(array('name', 'description', 'is_visible', 'is_plus', 'is_system', 'parent_id'));
		
		foreach ($categories as $cat) {
			$c = $cat->replicate();
			$c->user_id = $user->id;
			$c->save();
		}
		return $user;
	}	
	
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
