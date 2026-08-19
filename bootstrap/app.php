<?php

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // AdminMiddleware-কে আমি admin নামে ডাকতে চাই  ->middleware('admin')
        $middleware->alias([
            "admin" => AdminMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // কোনো error/exception হলে Laravel কী response দেবে সেটা এখানে customize করা যায়
        $exceptions->render(function(AuthenticationException $e, Request $request){
            if($request->is('api/*')){
                return response()->json([
                    "success" => false,
                    "message" => 'Unauthorized. Please provide a valid access token.'
                ], Response::HTTP_UNAUTHORIZED);
            }
        });
    })->create();
