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
    public function handle(Request $request, Closure $next)
    {
        $routeNames = ['viewLogin', 'viewRegister', 'loginWithGoogle', 'viewLoginWithGoogle'];

        if (auth()->guard('web')->check() || auth()->guard('admin')->check()) {
            if ($request->routeIs($routeNames)) {
                return redirect()->route('home');
            }
        }

        if (!auth()->guard('web')->check() && !auth()->guard('admin')->check()) {
            if (!$request->routeIs($routeNames)) {
                return redirect()->route('viewLogin');
            }
        }

        return $next($request);
    }
}
