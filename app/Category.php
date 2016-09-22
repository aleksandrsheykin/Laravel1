<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'categories';
	public $timestamps = false;

	public function getUser()
	{
		return $this->belongsTo('User');
	}

	public function getBalances()
	{
		return $this->hasMany('Balance');
	}

}