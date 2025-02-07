<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('web')->check()) {
            $routeNames = ['viewLogin', 'viewRegister', 'loginWithGoogle', 'viewLoginWithGoogle'];
            if (in_array(request()->route()->getName(), $routeNames)) {
                return redirect()->route('home');
            }
        }
        return $next($request);
    }
}
