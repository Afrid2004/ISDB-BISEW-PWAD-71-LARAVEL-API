<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            "name"          => ["required", "string", "max:255"],
            "email"         => ["required", "email", "max:255", "unique:users,email"],
            "password"      => ["required", "string", "min:8", "confirmed"]
            //confirmed used for password_confirmation name filed match with password name field
        ]);

        $user = User::create([
            "name"          => $validated['name'],
            "email"         => $validated['email'],
            "password"      => Hash::make($validated['password']),
        ]);

        //assign default role 
        $user->assignRole('student');

        // when user created then generate a sanctum token
        $token  = $user->createToken('auth_token')->plainTextToken;

        // send response to frontend 
        return response()->json([
            "message"               => "User registered successfully!",
            "user"                  => $user,
            "access_token"          => $token,
            "token_type"            => "Bearer"
        ], 201);
    }
}