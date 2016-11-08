<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model {

	protected $table = 'movements';
	public $timestamps = false;

	public function getUser()
	{
		return $this->belongsTo('User');
	}

	public function getCashFrom()
	{
		return $this->belongsTo('Cash', 'cash_id_from');
	}

	public function getCashTo()
	{
		return $this->belongsTo('Cash', 'cash_id_to');
	}

}