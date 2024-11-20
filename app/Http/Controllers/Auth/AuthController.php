<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponse; // Use your custom ApiResponse trait
use App\Http\Requests\RegisterRequest;  // Use the RegisterRequest form request

class AuthController extends Controller
{
    use ApiResponse; // Use the ApiResponse trait for consistent responses

    /**
     * Register a new user.
     *
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */

        // Create a new user
        public function register(Request $request)
        {
            // $validatedData = $request->validated(); // Get the validated data

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
    
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'user' => $user,
                'token' => $token
            ], 201);
        }
    
        public function login(Request $request)
        {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            if (!auth()->attempt($validated)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
    
            $user = auth()->user();
            
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        }
    
        public function logout()
        {
            auth()->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out']);
        }
}
