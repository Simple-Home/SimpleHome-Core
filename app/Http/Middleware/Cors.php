<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    Public function handle($request, Closure $next)
    {
        /*
         * @TODO Call to undefined method Symfony\Component\HttpFoundation\BinaryFileResponse::header()
         * http://localhost/livewire/livewire.js?id=e6704f81026a73a52725
        */
      return $next($request)
       ->header('Access-Control-Allow-Origin', '*')
       ->header('Access-Control-Allow-Methods',
                 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
       ->header('Access-Control-Allow-Headers',
                'Content-Type, Authorization, X-Requested-With, X-XSRF-TOKEN');
}
}
