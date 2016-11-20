<?php

namespace App\Http;

use Validator;

class StaticFunctions
{
    /**
     * 
     * This class contains global static functions
     * 
     */
	public static function createCategoryTree($categories) {
		if ($categories->count() == 0) return;
		
		$r = array();
		foreach ($categories as $val) {
			if ($val->parent_id) {
				$r[$val->parent_id]["childs"][$val->id] = $val;
			} else {
				$r[$val->id]["parent"] = $val;
			}
		}
		return $r;
	}
	
	public static function validateText($input_text) {
		$validator = Validator::make(
			array('input_text' => $input_text),
			array('input_text' => 'required')
		);
		return ($validator->passes())?$input_text:false;
	}
	
	public static function validateInt($num) {
		$num = intval($num);
		if ($num) {
			return $num;
		} else {
			return false;
		}
	}
}
