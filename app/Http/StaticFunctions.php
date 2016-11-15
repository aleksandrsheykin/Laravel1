<?php

namespace App\Http;

class StaticFunctions
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
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
