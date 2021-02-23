<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        auth()->setDefaultDriver($guard);
        Password::setDefaultDriver('admins');

        if (Auth::guard($guard)->check()) {
            return $request->expectsJson() ? response()->noContent() : redirect()->route('admin.home');
        }

        return $next($request);
    }

}
