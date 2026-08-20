<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// only admin can access this users api 
Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum', 'admin']);

//register a new user api
Route::post('/register', [AuthController::class, 'register']);