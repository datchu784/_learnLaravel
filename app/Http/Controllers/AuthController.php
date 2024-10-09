<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh']]);
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
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::parseToken()->refresh();
            return $this->respondWithToken($token);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not refresh token'], 401);
        }
    }

    protected function respondWithToken($token)
    {
        $expiration = JWTAuth::factory()->getTTL() * 60;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
            'refresh_token' => $this->createRefreshToken($token, $expiration),
        ]);
    }

    protected function createRefreshToken($token, $expiration)
    {
        $refreshToken = bin2hex(random_bytes(32)); // Tạo refresh token
        $refreshExpiration = $expiration + (7 * 24 * 60 * 60); // Ví dụ: 7 ngày sau khi access token hết hạn

        // Lưu refresh token vào cache hoặc database
        Cache::put('refresh_token:' . $refreshToken, $token, $refreshExpiration);

        return $refreshToken;
    }
}
