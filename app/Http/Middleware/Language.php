<?php

namespace App\Http\Middleware;

use Closure;

class Language
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
        $lang = $request->header('X-Request-Language');

        if (!$this->support($lang)) {
            $lang = config('app.locale');
        }
        
        app()->setLocale($lang);

        return $next($request);
    }

    private function support($lang)
    {
        return in_array($lang, config('app.locales'));
    }
}
