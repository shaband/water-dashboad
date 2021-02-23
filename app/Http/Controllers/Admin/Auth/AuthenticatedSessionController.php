<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{


    /**
     * @param LoginRequest $request
     * @return AdminResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        if ($request->expectsJson()) {
            return new AdminResource(Auth::user());
        }

        return redirect(RouteServiceProvider::HOME);
    }

    public function show()
    {
        return new AdminResource(auth()->user());
    }

    /**
     * Destroy an authenticated session.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        if ($request->expectsJson()) {
            return response()->noContent();
        }

        return redirect('/');
    }

}
