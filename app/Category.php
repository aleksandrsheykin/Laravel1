<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

class Category extends Model {
	
    public function __construct($attributes = array())
    {
		if (Auth::check()) {
			$this->attributes['user_id'] = Auth::User()->id;	//создаем категории только своего юзера
		}
        parent::__construct($attributes);
    }	
	
	/*public protected function where(attributes = array())
	{
		if (Auth::check()) {
			$this->attributes['user_id'] = Auth::User()->id;	//берем категории только своего юзера
		}
        parent::where($attributes);
    }	*/

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