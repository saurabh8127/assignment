<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|max:64',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors()->all(),
                'status' => false,
                'message' => 'Validation failed',
            ], 400);
        }

        //if login attempt fails
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'data' => [],
                'status' => false,
                'message' => 'Your email is not verified!',
            ], 400);
        }

        //create token
        $token = auth()->user()->createToken('Api token')->accessToken;

        return response()->json([
            'token' => $token,
            'data' => auth()->user(),
            'status' => true,
            'message' => 'Login, Welcome',
        ], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            'status' => true,
            'message' => 'User Logout.',
        ], 200);
    }
}