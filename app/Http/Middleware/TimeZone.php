<?php

namespace App\Http\Middleware;

use Closure;

class TimeZone
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestTime = $request->header('X-Request-Time');

        return $next($request);
    }
}
