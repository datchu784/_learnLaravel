<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use App\Services\UserService;

use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    protected  $service;

    public function __construct(UserService $service)
    {

        $this->middleware('auth:api', ['except' => ['login', 'register',]]);
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {

        $token = $this->service->login($request->email, $request->password);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request)
    {

        $data = $request->all();
        $token = $this->service->register($data);
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout();
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
