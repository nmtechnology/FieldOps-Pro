<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = [
        'ip_address',
        'country',
        'country_code',
        'region',
        'city',
        'latitude',
        'longitude',
        'timezone',
        'isp',
        'referrer_url',
        'referrer_domain',
        'landing_page',
        'user_agent',
        'device_type',
        'browser',
        'browser_version',
        'platform',
        'platform_version',
        'session_id',
        'verified',
        'verified_at',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Scope for verified visitors
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    /**
     * Scope for visitors from this week
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ]);
    }

    /**
     * Scope for visitors from last week
     */
    public function scopeLastWeek($query)
    {
        return $query->whereBetween('created_at', [
            now()->subWeek()->startOfWeek(),
            now()->subWeek()->endOfWeek(),
        ]);
    }
}
