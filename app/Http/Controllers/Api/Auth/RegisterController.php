<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request = $request->all();

        $validator = Validator::make($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages()->all(), 400);
        }

        //check if user already exit
        $user = User::where('email', $request['email'])->first();

        //send already registered message
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Already Registered',
            ], 200);
        }

        $request['password'] = bcrypt($request['password']);

        $user = User::create($request);

        //if login successfully
        return response()->json([
            'data' => [
                'token' => $user->createToken('Api token')->accessToken
            ],
            'status' => true,
            'message' => 'Logged in successfully',
        ], 200);
    }
}