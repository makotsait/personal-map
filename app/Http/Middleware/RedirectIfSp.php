<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class RedirectIfSp
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
        if (!\Agent::isMobile()) {
            return redirect('sp');
        } else {
            // return redirect('pc');
        }
        return $next($request);
    }
}
