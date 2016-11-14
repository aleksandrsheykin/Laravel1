<?php

namespace App\Http;

use Illuminate\Support\ServiceProvider;

class StaticFunctions extends ServiceProvider
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    public static function testfunc() {
		dd(111);
	}
}
