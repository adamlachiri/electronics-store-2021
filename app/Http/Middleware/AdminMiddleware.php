<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        // check if admin
        if (Auth::check() && Auth::user()->admin) {
            return $next($request);
        }

        // return forbidden
        abort("403");
    }
}
