<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SessionAlive
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
        if (Auth::check())
        {
            return $next($request);
        }

        return response()->json([
            'response' => false,
            'errorcode' => 400,
            'errormessage' => 'User not authorized'
        ]);
    }
}
