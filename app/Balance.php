<?php

namespace App;

class Balance extends Eloquent {

	protected $table = 'balance';
	public $timestamps = false;

	public function getCash()
	{
		return $this->hasOne('User');
	}

	public function getCategory()
	{
		return $this->belongsTo('Category');
	}

}