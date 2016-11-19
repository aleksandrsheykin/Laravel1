<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Cash extends Model {

	protected $table = 'cash';
	public $timestamps = true;
	
    protected $fillable = [
        'name', 'summa', 'description', 'ico'
    ];
	
    public function __construct($attributes = array())
    {
		$this->attributes['ico'] = '';
		$this->attributes['colour'] = '';
        parent::__construct($attributes);
    }	
	
    /*public static function create(array $attributes = [])
    {
		dd($attributes);
        parent::save($attributes);
    }*/

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
	
	public static function getBasicCashId($type) {
		if ($type=='expenses') { 
			$type = 1;
		} else {
			$type = 2;
		}
		return Cash::where('user_id', '=', Auth::User()->id)->where('is_basic', '=', $type)->get(array('id'));
	}

}