<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()) {
            if ($request->user()->role->name == 'user') {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
        

        return $next($request);
    }
}
