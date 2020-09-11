<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateProvider
{
    public function handle($request, Closure $next)
    {
        $provider = $request->header('X-Request-Provider');

        if (!$this->support($provider)) {
            $provider = 'api';
        }
        
        //config('auth.defaults.guard', $provider);

        return $next($request);
    }

    private function support($provider)
    {
        return in_array($provider, ['api', 'admin', 'web']);
    }
}
