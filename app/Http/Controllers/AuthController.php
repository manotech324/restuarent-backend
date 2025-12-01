<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Validation;
use App\Http\Requests\Validation\Register;

class AuthController extends Controller
{
    // REGISTER NEW USER
    public function register(Register $request)
    {
        $data = $request->validated(); // gets only validated data

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'password'  => Hash::make($data['password']),
            'role'      => $data['role'],
            'branch_id' => $data['branch_id'],
            'status'    => $data['status'],
        ]);
        return response()->json([
            'message' => 'User registered successfully',
            'data'    => $user
        ]);
    }

    // LOGIN USER
   public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!$token = auth()->attempt($credentials)) {
        return response()->json(['message' => 'Invalid email or password'], 401);
    }

    // Get logged-in user
    $user = auth()->user();

    return response()->json([
        'access_token' => $token,
        'token_type'   => 'bearer',
        'expires_in'   => auth()->factory()->getTTL() * 60,
        'user'         => $user
    ]);
}


    // CURRENT LOGGED-IN USER
    public function me()
    {
        return response()->json(auth()->user());
    }

    // LOGOUT
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Logged out successfully']);
    }

    // REFRESH TOKEN
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    // FORMAT TOKEN RESPONSE
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => auth()->user()
        ]);
    }
}
