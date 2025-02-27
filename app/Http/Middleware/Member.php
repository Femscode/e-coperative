<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Member
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
        if (auth()->user()->user_type == 'Member') {
            $key = 'intended_route';
            if (Session::has($key)) {
                $intendedRoute = Session::get($key);
                    // Optionally redirect or continue processing
                // Session::forget($key);
                // dd($intendedRoute);
                return redirect()->to(trim($intendedRoute)); 
            }
            return $next($request);
        }
        
        abort(403);
    }
}
