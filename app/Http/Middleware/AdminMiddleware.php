<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()){
            if(Auth::user()->user_role === 'admin'){
                return $next($request);
            }else{
                if(Auth::user()->user_role === 'user'){
                    return redirect()->route('user.dashboard');
                }else{
                    return redirect()->route('login');
                }
            }
        }else{
            return redirect()->route('login');
        }
    }
}
