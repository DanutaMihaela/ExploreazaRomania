<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Log;

class HostIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {

        if(!Auth::guard('host')->check()){
            return redirect('/?login=true');
        }

        return $next($request);
    }

}
