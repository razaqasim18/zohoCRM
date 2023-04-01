<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class Isblocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // dd(Auth::guard('web')->check());

        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if ($guard == "admin" && Auth::guard($guard)->user()->is_block) {
                Auth::guard($guard)->logout();
                return redirect()
                    ->route('admin.login.view')
                    ->with('error', 'Your account is not blocked');
            }

            if ($guard == "web" && Auth::guard($guard)->user()->is_block) {
                Auth::guard($guard)->logout();
                return redirect()
                    ->route('login')
                    ->with('error', 'Your account is not blocked');
            }
        }
        return $next($request);
    }
}
