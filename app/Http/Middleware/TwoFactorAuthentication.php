<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TwoFactorAuthentication
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
        if($request->user()->isTwoFactorAuthEnabled) {
            if($request->session()->has('two_factor_auth')) {
                if($request->session()->get('two_factor_auth') === true) {
                    return $next($request);
                }
            }

            return redirect()->route('two-factor-auth');
        }
        return $next($request);
    }
}
