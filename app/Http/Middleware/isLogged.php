<?php

namespace App\Http\Middleware;

use Closure;

class isLogged
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
        if($request->session()->get('is_logged') != "true")
            return redirect('/login');
        return $next($request);
    }
}
