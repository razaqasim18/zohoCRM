<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

// use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminLoginController extends Controller
{
    // use AuthenticatesUsers;

    public function __construct()
    {
        // $this->middleware('auth.admin');
        // if (!Auth::guard('admin')->check()) {
        //     return redirect()->route('admin.home');
        // }
    }

    public function showAdminLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.home');
        }
        return view('auth.admin_login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        $email = $request->email;
        $password = $request->password;
        $rememberToken = $request->remember;

        // if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
        if (\Auth::guard('admin')->attempt(['email' => $email, 'password' => $password], $rememberToken)) {
            $user = Auth::guard('admin')->user();

            return redirect()->intended('/admin');
        }
        return back()->with('email', "These credentials do not match our records.")->withInput($request->only('email', 'remember'));
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return $request->wantsJson()
        ? new JsonResponse([], 204)
        : redirect('/admin/login');
    }

}
