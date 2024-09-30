<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;

class DDoSProtection
{
    public function handle($request, Closure $next)
    {
        $key = $this->resolveRequest($request);

        if (RateLimiter::tooManyAttempts($key,60,1)) {
            return response('Too Many Attempts.', 429);
        }

        RateLimiter::hit($key,1);

        return $next($request);
    }

    protected function resolveRequest($request)
    {
        return sha1(
            $request->method() .
                '|' . $request->server('SERVER_NAME') .
                '|' . $request->path() .
                '|' . $request->ip()
        );
    }
}
