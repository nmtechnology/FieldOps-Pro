<?php

namespace App\Services;

use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jenssegers\Agent\Agent;

class VisitorTrackingService
{
    /**
     * Track a visitor when they land on the site
     */
    public function trackVisitor(Request $request): VisitorLog
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        $ipAddress = $this->getIpAddress($request);
        $geoData = $this->getGeolocationData($ipAddress);

        return VisitorLog::create([
            'ip_address' => $ipAddress,
            'country' => $geoData['country'] ?? null,
            'country_code' => $geoData['country_code'] ?? null,
            'region' => $geoData['region'] ?? null,
            'city' => $geoData['city'] ?? null,
            'latitude' => $geoData['latitude'] ?? null,
            'longitude' => $geoData['longitude'] ?? null,
            'timezone' => $geoData['timezone'] ?? null,
            'isp' => $geoData['isp'] ?? null,
            'referrer_url' => $request->headers->get('referer'),
            'referrer_domain' => $this->extractDomain($request->headers->get('referer')),
            'landing_page' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'device_type' => $this->getDeviceType($agent),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'platform' => $agent->platform(),
            'platform_version' => $agent->version($agent->platform()),
            'session_id' => $request->session()->getId(),
            'verified' => false,
        ]);
    }

    /**
     * Mark a visitor as verified after they solve the puzzle
     */
    public function markAsVerified(Request $request): ?VisitorLog
    {
        $sessionId = $request->session()->getId();
        
        $visitor = VisitorLog::where('session_id', $sessionId)
            ->where('verified', false)
            ->latest()
            ->first();

        if ($visitor) {
            $visitor->update([
                'verified' => true,
                'verified_at' => now(),
            ]);
        }

        return $visitor;
    }

    /**
     * Get the real IP address
     */
    private function getIpAddress(Request $request): string
    {
        // Check for proxy headers
        $ipAddress = $request->header('X-Forwarded-For') 
            ?? $request->header('X-Real-IP')
            ?? $request->ip();

        // If multiple IPs, get the first one
        if (str_contains($ipAddress, ',')) {
            $ipAddress = explode(',', $ipAddress)[0];
        }

        return trim($ipAddress);
    }

    /**
     * Get geolocation data from IP address using ip-api.com (free, no key required)
     */
    private function getGeolocationData(string $ipAddress): array
    {
        // Don't lookup localhost
        if (in_array($ipAddress, ['127.0.0.1', '::1', 'localhost'])) {
            return [
                'country' => 'Local',
                'country_code' => 'XX',
                'region' => 'Local',
                'city' => 'Local',
                'timezone' => 'UTC',
                'isp' => 'Local',
            ];
        }

        try {
            // Using ip-api.com free tier (45 requests/minute)
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$ipAddress}", [
                'fields' => 'status,country,countryCode,region,regionName,city,lat,lon,timezone,isp,query'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'success') {
                    return [
                        'country' => $data['country'] ?? null,
                        'country_code' => $data['countryCode'] ?? null,
                        'region' => $data['regionName'] ?? null,
                        'city' => $data['city'] ?? null,
                        'latitude' => $data['lat'] ?? null,
                        'longitude' => $data['lon'] ?? null,
                        'timezone' => $data['timezone'] ?? null,
                        'isp' => $data['isp'] ?? null,
                    ];
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Geolocation lookup failed: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Get device type from agent
     */
    private function getDeviceType(Agent $agent): string
    {
        if ($agent->isMobile()) {
            return 'mobile';
        } elseif ($agent->isTablet()) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    /**
     * Extract domain from URL
     */
    private function extractDomain(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $parsedUrl = parse_url($url);
        return $parsedUrl['host'] ?? null;
    }

    /**
     * Get weekly stats
     */
    public function getWeeklyStats(\DateTime $startDate = null, \DateTime $endDate = null): array
    {
        $startDate = $startDate ?? now()->subWeek()->startOfWeek();
        $endDate = $endDate ?? now()->subWeek()->endOfWeek();

        $visitors = VisitorLog::whereBetween('created_at', [$startDate, $endDate])->get();
        $verifiedVisitors = $visitors->where('verified', true);

        return [
            'period_start' => $startDate->format('Y-m-d'),
            'period_end' => $endDate->format('Y-m-d'),
            'total_visitors' => $visitors->count(),
            'verified_visitors' => $verifiedVisitors->count(),
            'verification_rate' => $visitors->count() > 0 
                ? round(($verifiedVisitors->count() / $visitors->count()) * 100, 2) 
                : 0,
            'top_countries' => $verifiedVisitors->groupBy('country')->map->count()->sortDesc()->take(10),
            'top_referrers' => $visitors->whereNotNull('referrer_domain')
                ->groupBy('referrer_domain')->map->count()->sortDesc()->take(10),
            'device_breakdown' => $verifiedVisitors->groupBy('device_type')->map->count(),
            'browser_breakdown' => $verifiedVisitors->groupBy('browser')->map->count()->sortDesc()->take(5),
            'platform_breakdown' => $verifiedVisitors->groupBy('platform')->map->count()->sortDesc()->take(5),
            'hourly_distribution' => $verifiedVisitors->groupBy(function($visitor) {
                return $visitor->created_at->format('H');
            })->map->count()->sortKeys(),
        ];
    }
}
