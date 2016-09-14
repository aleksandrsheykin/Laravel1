<?php

namespace App\Http\Middleware;

use Closure;
use Gate;

class AdminMiddleware
{

    public function handle($request, Closure $next)
    {
        if (!Gate::allows('isAdmin')) {
            return redirect('login');
        }

        return $next($request);
    }

}