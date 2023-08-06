<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PrivillageCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(collect(session()->get('user')[0]->role->permissions)->contains('en_name',$request->path())){
             return $next($request);
         }else {
             return  redirect(session()->get('user')[0]->role->permissions[0]->en_name);
         }
    }
}
