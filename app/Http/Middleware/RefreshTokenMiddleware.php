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

class RefreshTokenMiddleware extends BaseMiddleware
{
    const REFRESH_TTL = 30; // 30 seconds before expiration
    const BLACKLIST_GRACE_PERIOD = 60 * 24 * 30; // 30 days in minutes
    const CACHE_TTL = 30; // 5 minutes

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

                // Thực hiện request
                $response = $next($request);

                // Kiểm tra nếu token sắp hết hạn
                if ($this->shouldRefreshToken($payload)) {
                    return $this->handleTokenRefresh($response, $token, $user);
                }

                return $response;
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

    protected function handleBlacklistedToken($request, Closure $next, $token)
    {
        try {
            // Decode token mà không kiểm tra blacklist
            $payload = JWTAuth::getJWTProvider()->decode($token);

            // Kiểm tra xem token có thực sự của user không
            $user = \App\Models\User::find($payload['sub']);

            if (!$user) {
                throw new Exception('User not found');
            }

            // Kiểm tra thời gian tạo token
            $tokenCreatedAt = $payload['iat'];
            $now = time();

            // Nếu token được tạo trong khoảng thời gian cho phép
            if ($now - $tokenCreatedAt <= self::BLACKLIST_GRACE_PERIOD * 60) {
                // Tạo token mới hoặc lấy từ cache
                $newToken = $this->getOrCreateNewToken($user->id);

                // Cập nhật token trong request
                $request->headers->set('Authorization', 'Bearer ' . $newToken);

                // Thực hiện lại request với token mới
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
            // Decode token mà không kiểm tra hết hạn
            $payload = JWTAuth::getJWTProvider()->decode($token);

            // Lấy user từ payload
            $user = \App\Models\User::find($payload['sub']);

            if (!$user) {
                throw new Exception('User not found');
            }

            // Tạo token mới hoặc lấy từ cache
            $newToken = $this->getOrCreateNewToken($user->id);

            // Cập nhật token trong request
            $request->headers->set('Authorization', 'Bearer ' . $newToken);

            // Thực hiện lại request với token mới
            $response = $next($request);

            return $this->setTokenResponse($response, $newToken);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Could not refresh token',
                'message' => $e->getMessage()
            ], 401);
        }
    }

    protected function shouldRefreshToken($payload)
    {
        return $payload->get('exp') - time() < static::REFRESH_TTL;
    }

    protected function handleTokenRefresh($response, $token, $user)
    {
        try {
            // Tạo token mới hoặc lấy từ cache
            $newToken = $this->getOrCreateNewToken($user->id);

            return $this->setTokenResponse($response, $newToken);
        } catch (Exception $e) {
            // Nếu không refresh được, vẫn trả về response gốc
            return $response;
        }
    }

    protected function setTokenResponse($response, $token)
    {
        if (method_exists($response, 'getContent')) {
            $content = json_decode($response->getContent(), true) ?: [];
            $content['token'] = $token;
            $response->setContent(json_encode($content));
        }

        // Thêm token vào header
        $response->headers->set('Authorization', 'Bearer ' . $token);

        return $response;
    }

    protected function getTokenFromRequest($request)
    {
        if ($token = $request->bearerToken()) {
            return $token;
        }

        if ($token = $request->header('Authorization')) {
            $token = str_replace('Bearer ', '', $token);
            return $token;
        }

        return null;
    }

    protected function getOrCreateNewToken($userId)
    {
        $cacheKey = 'user_token_' . $userId;

        // Kiểm tra xem token có trong cache không
        if (Cache::has($cacheKey)) {
            $cachedToken = Cache::get($cacheKey);
            $payload = JWTAuth::setToken($cachedToken)->getPayload();

            // Kiểm tra xem token trong cache còn hạn không
            if ($payload->get('exp') - time() > static::REFRESH_TTL) {
                return $cachedToken;
            }
        }

        // Nếu không có trong cache hoặc đã hết hạn, tạo token mới
        $user = \App\Models\User::find($userId);
        $newToken = JWTAuth::fromUser($user);

        // Lưu token mới vào cache
        Cache::put($cacheKey, $newToken, self::CACHE_TTL);

        return $newToken;
    }

    protected function handleInvalidToken($request, Closure $next, $token)
    {
        return response()->json([
            'error' => 'Invalid token',
            'message' => 'The token is invalid'
        ], 401);
    }
}
