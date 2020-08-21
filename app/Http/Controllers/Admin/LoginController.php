<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    public function showLoginForm()
    {
        if (auth()->guard('admin')->check()) {
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

        if (auth()->guard('admin')->attempt($cridentials, $remember)) {
            Admin::where('email',$request->get('email'))
                ->update(['last_logged_in_at'=> now()]);
            return redirect()->route('admin.store.index');
        }

        return redirect()->route('admin.login-form')->with('fail', __('admin_message.auth.fail'))->withInput();
    }

    public function logout()
    {
        auth()->guard('admin')->logout();

        return redirect()->route('admin.login-form');
    }
}
