<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Category extends Model {
	
    public function __construct($attributes = array())
    {
		$this->attributes['user_id'] = Auth::User()->id;	//по умолчанию берем категории только своего юзера
        parent::__construct($attributes);
    }	

	protected $table = 'categories';
	
	public $timestamps = false;
	
    protected $fillable = [
        'name', 'description', 'is_plus', 'parent_id', 'is_visible',
    ];	

	public function getUser()
	{
		return $this->belongsTo('User');
	}

	public function getBalances()
	{
		return $this->hasMany('Balance');
	}

}