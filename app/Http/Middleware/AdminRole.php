<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminRole extends Middleware
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
        if(Auth::User()->role>1)
            return $next($request);
        return redirect()->back();
    }
}
