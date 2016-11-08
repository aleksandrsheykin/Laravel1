<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model {

	protected $table = 'cash';
	public $timestamps = true;

	public function getUser()
	{
		return $this->belongsTo('User');
	}

	public function getMovementFrom()
	{
		return $this->hasMany('Movement', 'cash_id_from');
	}

	public function getMovementTo()
	{
		return $this->hasMany('Movement', 'cash_id_to');
	}

	public function getBalances()
	{
		return $this->hasMany('Balance');
	}

}