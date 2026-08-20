<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// only admin can access this users api 
Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum', 'admin']);

//register or login a user with api
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post("/logout", [AuthController::class, 'logout']);
    Route::get("/profile", [AuthController::class, 'profile']);
});