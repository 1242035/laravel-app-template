<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Auth;

class LoginController extends BaseController
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect(route('admin.store.index'));
        }
        return view('admin.login.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $cridentials = $request->only('email', 'password');
        $remember = ($request->remember) ? true : false;

        if (Auth::guard('admin')->attempt($cridentials, $remember)) {
            AdminUser::where('email',$request->get('email'))
                ->update(['last_logged_in_at'=> now()]);
            return redirect()->route('admin.store.index');
        }

        return redirect()->route('admin.login-form')->with('fail', __('admin_message.auth.fail'))->withInput();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login-form');
    }
}
