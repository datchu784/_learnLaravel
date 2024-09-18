<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected  $_service;

    public function __construct(UserService $service)
    {

        $this->middleware('auth:api', ['except' => ['login', 'register',]]);
        $this->_service = $service;
    }

    public function login(LoginRequest $request)
    {
        //$credentials = $request->only('email', 'password');
        $email = $request->email;
        $password=$request->password;
        $user= User:: where('email',$email)->where('password',$password)->first();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        else
        {
           // phai la 1 array
            $token = JWTAuth::customClaims(['sub='>$user->id])->fromUser($user);
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request)
    {

        $data = $request->all();
        // $request->validate();

        $user = $this->_service->create($data);

        $token = JWTAuth::customClaims(['sub=' > $user->id])->fromUser($user);
        //return $user->id;

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout();

        // request()->session()->invalidate();

        // request()->session()->regenerateToken();
        return response()->json(['message' => 'Successfully logged out'],200);
    }


    public function respondWithToken($token)
    {

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',

        ]);
    }
}
