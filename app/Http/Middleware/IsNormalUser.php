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
        if(auth()->user() && auth()->user()->urole_id == '7076f925-ec51-48c7-8b3b-e33709bb1ffe'){
            return $next($request);
        }
        return response()->json(['message' => 'You are not authorized as user role'], 403);
    }
}
