<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class DDoSProtection
{
    public function handle($request, Closure $next)
    {
        $key = $this->resolveRequest($request);

        if (Cache::has("ban:$key")) {
            RateLimiter::clear($key);
            return response('Bạn đã bị cấm. Hãy thử lại sau 10s', 403);
        }



        if (RateLimiter::tooManyAttempts($key,60,1)) {
            $this->banFor10Minute($key,1);
            return response('Too Many Attempts.', 429);
        }

        RateLimiter::hit($key);

        return $next($request);
    }

    protected function resolveRequest($request)
    {
        return sha1(
            $request->method().
                '|' . $request->server('SERVER_NAME') .
                '|' . $request->path() .
                '|' . $request->ip()
        );
    }

    protected function banFor10Minute($key)
    {
        Cache::put("ban:$key","bi ban roi nhe", now()->addMinute(10));
    }
}
