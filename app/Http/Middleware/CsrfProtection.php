<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\TokenMismatchException;

class CsrfProtection
{
    public function handle($request, Closure $next)
    {
        if ($this->isReading($request) || $this->tokensCsrfMatch($request)) {
            return $next($request);
        }

        throw new TokenMismatchException('CSRF token mismatch.');
    }

    protected function isReading($request)
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }

    protected function tokensCsrfMatch($request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (!$token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encryptCookieToken($header);
        }

        return hash_equals((string) $request->session()->token(), (string) $token);
    }

    protected function encryptCookieToken($token)
    {
        return hash_hmac('sha256', $token, env('APP_KEY'));
    }
}
