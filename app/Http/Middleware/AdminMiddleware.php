<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // hasRole comes from stipe role permission 
        if(!$request->user()->hasRole('admin')){
            return response()->json([
                "success" => false,
                "message" => "Unauthorized Access"
            ], 403);
        }
        return $next($request);
    }
}
