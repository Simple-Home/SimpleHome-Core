<?php

namespace App\Api\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
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
        // if the session does not have 'authenticated' forget the user and redirect to login
        if ($request->session()->get('authenticated', false) === true) {
            return $next($request);
        }
        $request->session()->forget('authenticated');
        $request->session()->forget('user');
        return redirect()->action("CustomAuthController@showLoginForm")->with('error', 'Your session has expired.');
    }
}
