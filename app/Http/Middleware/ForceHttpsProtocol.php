<?php

namespace App\Http\Middleware;

use Closure;

class ForceHttpsProtocol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && env('APP_ENV') === 'production') { // 本番環境のみ常時SSL化する
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
