<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8",
        ]);

        $validated["password"] = Hash::make($validated["password"]);

        $user = User::create($request->all());

        return response()->json([
            "data" => $user,
            "accessToken" => $user->createToken("api-token")->plainTextToken,
            "tokenType" => "Bearer"
        ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Login informations invalid'
            ], 401);
        }

        $user = User::where('email', $validated['email'])->first();

        return response()->json([
            'accessToken' => $user->createToken('apiToken')->plainTextToken,
            'tokenType' => 'Bearer'
        ]);
    }
}
