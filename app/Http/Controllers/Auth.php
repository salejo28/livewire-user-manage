<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');
        $token = FacadesAuth::attempt($credentials);
        if (!$token)
            return response()->json([
                'status' => 'failed',
                'message' => 'Email or password incorrect'
            ], 401);
        $user = FacadesAuth::user();
        return response()->json([
            'status' => 'ok',
            'user' => $user,
            'message' => "Welcome back {$user->name}",
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }

    public function register(UserRequest $request) {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);
        $token = FacadesAuth::login($user);
        return response()->json([
            'status' => 'ok',
            'user' => $user,
            'message' => "Welcome {$user->name}",
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }

    public function logout() {
        FacadesAuth::logout();
        return response()->json([
            'status' => 'ok',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'ok',
            'user' => FacadesAuth::user(),
            'authorization' => [
                'token' => FacadesAuth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
