<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model {

	protected $table = 'balance';
	public $timestamps = false;

	public function getCash()
	{
		return $this->hasOne('Cash');
	}

	public function getCategory()
	{
		return $this->belongsTo('Category');
	}

}