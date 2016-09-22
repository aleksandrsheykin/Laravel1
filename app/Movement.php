<?php

namespace App;

class Movement extends Eloquent {

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