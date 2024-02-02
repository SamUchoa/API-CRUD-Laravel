<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate(['name' => 'required|string', 'password' => 'required|string|confirmed', 'email' => 'required|string|unique:users,email']);

        $user = User::create(['name' => $fields['name'], 'password' => Hash::make($fields['password']), 'email' => $fields['email']]);

        $token = $user->createToken($user->id)->plainTextToken;

        $response = ['user' => $user, 'password' => $user->password, 'token' => $token];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate(['password' => 'required|string', 'email' => 'required|string']);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'incorrect email or password '], 401);
        }

        $token = $user->createToken($user->id)->plainTextToken;

        return response([
            'message' => 'Login successfully',
            'token' => $token
        ], 201);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ['message' => 'logout successfully'];
    }
}
