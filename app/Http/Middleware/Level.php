<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Redirect;
use Auth;

class Level
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$levels)
    {

        if (in_array($request->user()->level, $levels)) {
            return $next($request);
        }

        if (Auth::guard('user')->user()->level == "admin") {
            return Redirect::to('dashboard');
        } elseif (Auth::guard('user')->user()->level == "bpo") {
            return Redirect::to('dashboard');
        } elseif (Auth::guard('user')->user()->level == "bpomnjr") {
            return Redirect::to('dashboard');
        }
    }
}
