<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsNormalUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user() && auth()->user()->urole_id == '1d3c9d35-3d02-4b42-ad44-b75ca8c4e4fa' && auth()->user()->email_verified_at){
            return $next($request);
        } else if(!auth()->user()){
            return response()->json(['message' => 'You are not authenticated'], 403);
        } else if(!(auth()->user()->urole_id == '1d3c9d35-3d02-4b42-ad44-b75ca8c4e4fa')){
            return response()->json(['message' => 'You are not authorized as user role'], 403);
        } else if(!auth()->user()->email_verified_at){
            return response()->json(['message' => 'Your email address is not verified'], 401);
        }
    }
}
