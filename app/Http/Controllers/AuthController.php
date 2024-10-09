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
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->input('refresh_token');
        if (!$refreshToken) {
            return response()->json(['error' => 'Refresh token not provided'], 400);
        }

        $cachedData = Cache::get('refresh_token:' . $refreshToken);
        if (!$cachedData) {
            return response()->json(['error' => 'Invalid refresh token'], 401);
        }

        $cachedToken = $cachedData['token'];
        $userId = $cachedData['user_id'];

        try {
            $oldPayload = JWTAuth::setToken($cachedToken)->getPayload();
            $tokenUserId = $oldPayload->get('sub');

            if ($tokenUserId != $userId) {
                Cache::forget('refresh_token:' . $refreshToken);
                return response()->json(['error' => 'Invalid token ownership'], 401);
            }

            Cache::forget('refresh_token:' . $refreshToken);

            $newToken = JWTAuth::refresh($cachedToken);

            return $this->respondWithToken($newToken);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not refresh token'], 401);
        }
    }

    protected function respondWithToken($token)
    {
        $expiration = JWTAuth::factory()->getTTL() * 60;
        $refreshExpiration = $expiration + (7 * 24 * 60 * 60); // 7 ngày sau khi access token hết hạn

        $payload = JWTAuth::setToken($token)->getPayload();
        $userId = $payload->get('sub');

        $refreshToken = bin2hex(random_bytes(32));

        Cache::put('refresh_token:' . $refreshToken, [
            'token' => $token,
            'user_id' => $userId
        ], $refreshExpiration);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
            'refresh_token' => $refreshToken,
        ]);
    }
}
