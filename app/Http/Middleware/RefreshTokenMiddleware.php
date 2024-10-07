<?php

namespace App\Http\Middleware;


use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RefreshTokenMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {

        try {
            $token = JWTAuth::parseToken();
            $payload = $token->getPayload();

            // Kiểm tra xem token còn thời hạn sử dụng trên 5 phút không
            if ($payload->get('exp') - time() < 300) {
                // Nếu token sắp hết hạn, tạo token mới
                $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                $user = JWTAuth::setToken($refreshed)->toUser();
                $request->headers->set('Authorization', 'Bearer ' . $refreshed);

                // Trả về token mới trong response
                $response = $next($request);
                return $response->header('Authorization', 'Bearer ' . $refreshed);
            }
        } catch (TokenExpiredException $e) {
            try {
                // Token đã hết hạn, thử refresh
                $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                $user = JWTAuth::setToken($refreshed)->toUser();
                $request->headers->set('Authorization', 'Bearer ' . $refreshed);

                // Trả về token mới trong response
                $response = $next($request);
                return $response->header('Authorization', 'Bearer ' . $refreshed);
            } catch (Exception $e) {
                // Không thể refresh token
                return response()->json(['error' => 'Unauthorized', 'message' => $e->getMessage()], 401);
            }
        } catch (TokenInvalidException $e) {
            // Token không hợp lệ
            return response()->json(['error' => 'Invalid token', 'message' => $e->getMessage()], 401);
        } catch (Exception $e) {
            // Lỗi khác
            return response()->json(['error' => 'Unauthorized', 'message' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
