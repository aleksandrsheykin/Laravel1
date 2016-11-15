<?php

namespace App\Http;

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
}
