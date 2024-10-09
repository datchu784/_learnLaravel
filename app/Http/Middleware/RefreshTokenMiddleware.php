<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RefreshTokenMiddleware extends BaseMiddleware
{
    const REFRESH_TTL = 30; // 30 seconds before expiration
    const BLACKLIST_GRACE_PERIOD = 60 * 24 * 30; // 30 days in minutes
    const CACHE_TTL = 30; // 30 seconds


    public function handle($request, Closure $next)
    {
        try {

            if (!$token = $this->getTokenFromRequest($request)) {
                return response()->json(['error' => 'Token not provided'], 401);
            }

            try {
                // Thử parse token hiện tại
                $payload = JWTAuth::setToken($token)->getPayload();
                $user = JWTAuth::parseToken()->authenticate();

                // Kiểm tra và tự động làm mới token nếu cần
                $token = $this->checkAndRefreshToken($user->id, $token);

                // Cập nhật token trong request
                $request->headers->set('Authorization', 'Bearer ' . $token);

                // Thực hiện request
                $response = $next($request);

                return $this->setTokenResponse($response, $token);
            } catch (TokenExpiredException $e) {
                return $this->handleExpiredToken($request, $next, $token);
            } catch (TokenBlacklistedException $e) {
                return $this->handleBlacklistedToken($request, $next, $token);
            } catch (TokenInvalidException $e) {
                return $this->handleInvalidToken($request, $next, $token);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => $e->getMessage()
            ], 401);
        }


    }

    protected function checkAndRefreshToken($userId, $currentToken)
    {
        $cacheKey = 'user_token_' . $userId;

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $payload = JWTAuth::setToken($currentToken)->getPayload();
        $expirationTime = Carbon::createFromTimestamp($payload->get('exp'));
        $now = Carbon::now();

        if ($expirationTime->diffInSeconds($now) <= static::REFRESH_TTL) {
            $newToken = JWTAuth::refresh($currentToken);
            Cache::put($cacheKey, $newToken, static::CACHE_TTL);
            return $newToken;
        }

        return $currentToken;
    }

    protected function handleBlacklistedToken($request, Closure $next, $token)
    {
        try {
            $payload = JWTAuth::getJWTProvider()->decode($token);
            $user = \App\Models\User::find($payload['sub']);

            if (!$user) {
                throw new Exception('User not found');
            }

            $tokenCreatedAt = Carbon::createFromTimestamp($payload['iat']);
            $now = Carbon::now();

            if ($now->diffInMinutes($tokenCreatedAt) <= self::BLACKLIST_GRACE_PERIOD) {
                $newToken = $this->checkAndRefreshToken($user->id, $token);
                $request->headers->set('Authorization', 'Bearer ' . $newToken);
                $response = $next($request);
                return $this->setTokenResponse($response, $newToken);
            }

            throw new Exception('Token has exceeded grace period');
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Invalid blacklisted token',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    protected function handleExpiredToken($request, Closure $next, $token)
    {
        try {
            $payload = JWTAuth::getJWTProvider()->decode($token);
            $user = \App\Models\User::find($payload['sub']);

            if (!$user) {
                throw new Exception('User not found');
            }

            $newToken = JWTAuth::fromUser($user);
            Cache::put('user_token_' . $user->id, $newToken, static::CACHE_TTL);

            $request->headers->set('Authorization', 'Bearer ' . $newToken);
            $response = $next($request);
            return $this->setTokenResponse($response, $newToken);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Could not refresh token',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    protected function setTokenResponse($response, $token)
    {
        if (method_exists($response, 'getContent')) {
            $content = json_decode($response->getContent(), true) ?: [];
            $content['access_token'] = $token;
            $response->setContent(json_encode($content));
        }

        $response->headers->set('Authorization', 'Bearer ' . $token);
        return $response;
    }

    protected function getTokenFromRequest($request)
    {
        if ($token = $request->bearerToken()) {
            return $token;
        }

        if ($token = $request->header('Authorization')) {
            return str_replace('Bearer ', '', $token);
        }

        return null;
    }

    protected function handleInvalidToken($request, Closure $next, $token)
    {
        return response()->json([
            'error' => 'Invalid token',
            'message' => 'The token is invalid'
        ], 401);
    }
}
