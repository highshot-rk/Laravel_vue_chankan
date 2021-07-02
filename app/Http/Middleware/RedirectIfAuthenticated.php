<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($guard === 'admin') {
                $role = Auth::guard('admin')->user()->owner;
                if ($role === config('const.manager.manager')) {
                    return redirect()->route('admin.home.index');
                } else if ($role === config('const.manager.owner')) {
                    return redirect()->route('admin.clients.index');
                }
            } elseif ($guard === 'charge') {
                return redirect('charge/calendar');
            } else {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
