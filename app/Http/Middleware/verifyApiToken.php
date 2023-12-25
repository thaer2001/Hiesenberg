<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class verifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token=$request->bearerToken();
        if(!$token){
            return response()->json([
                'error'=>'Token Not Provided'
            ]);
        }
        $hashedToken=hash('sha256',$token);
        $user=User::where('api_token',$hashedToken)->first();
        // $user=Auth::guard('api')->user();
        if(!$user){
            return response()->json([
                'error'=>'Invalid Token'
            ]);
        }
        Auth::login($user);
        return $next($request);
    }
}
