<?php


namespace App\Filters;

use Closure;

class UsersFilterName
{
    public function handle($request, Closure $next)
    {
        if (! request()->has('name')) {
            return $next($request);
        }
        return $next($request)->where('name', request()->input('name'));
    }



}
