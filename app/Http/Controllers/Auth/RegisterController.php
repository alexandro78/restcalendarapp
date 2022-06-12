<?php

namespace App\Http\Controllers;

use App\Modedls\User;
use Illuminate\Http\Request;
use Illuminate\Sapport\Facades\Hash;
use Illuminate\Sapport\Facades\Validator;
use Illuminate\Sapport\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);
            if ($validator->fails()) {

                return response([
                    'error' => $validator->errors()->all(),
                ], 422);
            }
            $request['password'] = Hash::make($request['password']);
            $request['remember_token'] = Str::random(10);
            $user = User::create($request->toArray());

            return response()->json([
                'status_code' => 200,
                'message' => 'Registration succesfull',
            ]);

        } catch (Exception $error) {

            return response()->json([
                'status_code' => 500,
                'message' => 'Error Registration',
                'error' => $error,
            ]);

        }
    }
}
