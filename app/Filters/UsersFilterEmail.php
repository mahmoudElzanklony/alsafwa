<?php


namespace App\Filters;

use Closure;

class UsersFilterEmail
{
    public function handle($request, Closure $next)
    {
        if (! request()->has('email')) {
            return $next($request);
        }
        return $next($request)->where('email', request()->input('email'));
    }
}
