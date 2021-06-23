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
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            /** @var User $lang */
            $user = Auth::user();
            // Get the user specific language
            $lang = $user->language;
            App::setLocale($lang);
        } else {
            $lang = $this->getBrowserLanguage();
            App::setLocale(array_key_first($lang));
        }


        return $next($request);
    }

    private function getBrowserLanguage()
    {
        $prefLocales = array_reduce(
            explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']),
            function ($res, $el) {
                list($l, $q) = array_merge(explode(';q=', $el), [1]);
                $res[$l] = (float)$q;
                return $res;
            }, []);
        arsort($prefLocales);

        return $prefLocales;
    }
}
