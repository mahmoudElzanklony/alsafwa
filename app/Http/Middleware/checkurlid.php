<?php

namespace App\Http\Middleware;

use App\Models\Clients;
use App\Models\Services_Requests;
use Closure;
use Illuminate\Http\Request;

class checkurlid
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
        if(request()->has('id')){
            // check id is valid

            if(request()->path() == "clients-services"){
                if (Clients::query()->find(request('id'))) {
                    return $next($request);
                } else {
                    return back();
                }
            }else {

                if (Services_Requests::query()->find(request('id')) != null) {
                    return $next($request);
                } else {
                    return back();
                }
            }
        }else {
            return $next($request);
        }
    }
}
