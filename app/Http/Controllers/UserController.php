<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userData(Request $request){
        return $request->user();
    }
    
    public function logout(Request $request){
        Auth::user()->token()->delete();
    }
}
