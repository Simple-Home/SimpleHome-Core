<?php

namespace App\Api\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateByToken
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
        if($request->header('Authorization')){
            return $next($request);
          }
          return response()->json([
            'message' => 'Not a valid API request.',
          ]);
    }
}
