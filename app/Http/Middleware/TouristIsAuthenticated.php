<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Log;

class TouristIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {

        if(!Auth::guard('tourist')->check()){
            return redirect('/?login=true');
        }

        return $next($request);
    }

}
