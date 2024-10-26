<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class T2fa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->tfa == 1 && auth()->user()->active == 0) {
            return redirect()->route('t2fa');
        }
        return $next($request);
    }
}
