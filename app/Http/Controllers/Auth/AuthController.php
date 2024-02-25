<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __invoke(Request $request) : JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' => [
                    'email' => ['Les identifiants sont incorrects.'],
                ],
            ], 422);
        }

        $token = auth()->user()->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
        ]);

        $user = User::class::create([
            'name' => mb_strtoupper($validate['name']),
            'email' => $validate['email'],
            'password' => bcrypt($validate['password']),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function logout(Request $request) : JsonResponse
    {
        if (auth()->check()) {
            auth()->user()->tokens()->each(function ($token, $key) {
                $token->delete();
            });

            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'error' => 'Unauthenticated',
        ], 401);
    }
}
