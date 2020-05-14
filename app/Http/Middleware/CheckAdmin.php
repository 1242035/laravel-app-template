<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdmin
{
    private $exceptActions = [
        'App\Http\Controllers\Admin\LoginController@showLoginForm',
        'App\Http\Controllers\Admin\LoginController@login',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::guard('admin')->check() || $this->except($request->route()->getActionName())) {
            return $next($request);
        }
        if($request->ajax()){
            return response()->json([
                'status' => false,
                'message' => trans('auth.failed')
            ]);
        }
        return redirect()->route('admin.login-form');
    }

    private function except($action)
    {
        return in_array($action, $this->exceptActions);
    }
}
