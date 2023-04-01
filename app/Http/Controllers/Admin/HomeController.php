<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login.view');
        }
        return view('admin_home');
    }

}
