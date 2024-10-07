<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;

class UserAccessInfo
{
    public function handle(Request $request, Closure $next)
    {
        $agent = new Agent();

        $userInfo = [
            'ip' => $request->ip(),
            'device' => $this->getDeviceType($agent),
            'platform' => $agent->platform(),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            //'location' => $this->getLocation($request->ip()),
        ];

        session(['user_access_info' => $userInfo]);

        Log::info('User Info:', $userInfo);

        return $next($request);
    }

    private function getDeviceType(Agent $agent)
    {
        if ($agent->isRobot()) {
            return 'Robot/Bot';
        } elseif ($agent->isPhone()) {
            return 'Mobile Phone';
        } elseif ($agent->isTablet()) {
            return 'Tablet';
        } elseif ($agent->isDesktop()) {
            return 'Desktop';
        } elseif ($agent->isMobile()) {
            return 'Other Mobile Device';
        } else {
            return 'Unknown Device';
        }
    }

    private function getLocation($ip)
    {

        if ($this->isPrivateIP($ip)) {
            return [
                'country' => 'Local Network',
                'city' => 'Private',
                'region' => 'Private',
                'latitude' => null,
                'longitude' => null,
            ];
        }
        $cacheKey = "location_data_{$ip}";

        // Kiểm tra cache trước
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            Log::info("Attempting to fetch location for IP: " . $ip);
            $response = Http::get("https://ipapi.co/{$ip}/json/");

            Log::info("API Response: " . $response->body());

            if ($response->successful()) {
                $data = $response->json();
                Log::info("Parsed data: ", $data);
                $locationData = [
                    'country' => $data['country_name'] ?? 'Unknown',
                    'city' => $data['city'] ?? 'Unknown',
                    'region' => $data['region'] ?? 'Unknown',
                    'latitude' => $data['latitude'] ?? null,
                    'longitude' => $data['longitude'] ?? null,
                ];

                // Cache kết quả trong 1 giờ
                Cache::put($cacheKey, $locationData, now()->addHour());

                return $locationData;
            } else {
                Log::warning("Unsuccessful API response. Status: " . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Error fetching location data', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }

        $defaultLocation = [
            'country' => 'Unknown',
            // 'city' => 'Unknown',
            // 'region' => 'Unknown',
            // 'latitude' => null,
            // 'longitude' => null,
        ];

        // Cache kết quả mặc định trong 15 phút để tránh gọi API liên tục khi có lỗi
        Cache::put($cacheKey, $defaultLocation, now()->addMinutes(15));

        return $defaultLocation;
    }

    private function isPrivateIP($ip)
    {
        $privateRanges = [
            ['10.0.0.0', '10.255.255.255'],
            ['172.16.0.0', '172.31.255.255'],
            ['192.168.0.0', '192.168.255.255']
        ];

        $longIp = ip2long($ip);
        foreach ($privateRanges as $range) {
            if ($longIp >= ip2long($range[0]) && $longIp <= ip2long($range[1])) {
                return true;
            }
        }
        return false;
    }
}
