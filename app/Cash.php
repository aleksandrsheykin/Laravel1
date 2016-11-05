<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Auth;

class Cash extends Authenticatable {

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