<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;



class AuthController extends Controller
{
    public function login(Request $request){
        // Validate and attempt login...

        // Generate a new token
        $token = Str::random(80);

        // Store the token in the `api_token` column for the user
        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return response()->json([
            'message'=>"Welcome Back {$request->name}",
            'token'=>$token
        ]);
    }
    public function register(Request $request){
        $user=new User();
        $user->name=$request->input('name');
        $user->phone_number=$request->input('phone_number');
        $user->password=$request->input('password');

        // Generate a new token
        $token = Str::random(80);

        // Store the token in the `api_token` column for the user
        $user->api_token = hash('sha256', $token);

        $user->save();

        return response()->json([
            'message'=>"Welcome {$user->name}",
            'token'=>$token
        ]);
    }
}
