<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if ($guard == "admin" && Auth::guard($guard)->check()) {
                return redirect()->route('admin.login.view');
            }
            if ($guard == "web" && Auth::guard($guard)->check()) {
                return redirect()->route('dashboard');
            }
        }
        return $next($request);

        // if (Auth::getDefaultDriver() == 'admin' && Auth::guard('admin')->check()
        // ) {
        //     return redirect('/admin/dashboard');
        // }

        // if (Auth::guard($guard)->check()) {
        //     return redirect('/dashboard');
        // }
        // return $next($request);
    }
}
