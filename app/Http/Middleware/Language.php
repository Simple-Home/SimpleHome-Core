<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check())
        {
            // Get the user specific language
            $lang = Auth::user()->language;
            switch ($lang) {
                case 1:
                    App::setLocale("en");
                    break;
                case 2:
                    App::setLocale("cs");
                    break;
                default:
                    App::setLocale("en");
                    break;
            }
        }
        return $next($request);
    }
}
