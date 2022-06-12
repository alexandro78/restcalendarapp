<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
