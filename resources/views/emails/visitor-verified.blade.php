<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border-left: 3px solid #667eea;
        }
        .info-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            background: #10b981;
            color: white;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .timestamp {
            color: #999;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✅ New Verified Visitor</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">A visitor has successfully verified on FieldEngineer Pro</p>
        </div>
        
        <div class="content">
            <p><span class="badge">VERIFIED</span></p>
            
            <h3 style="margin-top: 25px; margin-bottom: 15px; color: #333;">📍 Location Information</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">IP Address</div>
                    <div class="info-value">{{ $visitor->ip_address }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Country</div>
                    <div class="info-value">{{ $visitor->country ?? 'Unknown' }} {{ $visitor->country_code ? '(' . $visitor->country_code . ')' : '' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Region</div>
                    <div class="info-value">{{ $visitor->region ?? 'Unknown' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">City</div>
                    <div class="info-value">{{ $visitor->city ?? 'Unknown' }}</div>
                </div>
                @if($visitor->latitude && $visitor->longitude)
                <div class="info-item full-width">
                    <div class="info-label">Coordinates</div>
                    <div class="info-value">{{ $visitor->latitude }}, {{ $visitor->longitude }}</div>
                </div>
                @endif
                <div class="info-item">
                    <div class="info-label">Timezone</div>
                    <div class="info-value">{{ $visitor->timezone ?? 'Unknown' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">ISP</div>
                    <div class="info-value">{{ $visitor->isp ?? 'Unknown' }}</div>
                </div>
            </div>

            <h3 style="margin-top: 25px; margin-bottom: 15px; color: #333;">💻 Device & Browser</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Device Type</div>
                    <div class="info-value">{{ ucfirst($visitor->device_type ?? 'Unknown') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Browser</div>
                    <div class="info-value">{{ $visitor->browser ?? 'Unknown' }} {{ $visitor->browser_version ? 'v' . $visitor->browser_version : '' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Operating System</div>
                    <div class="info-value">{{ $visitor->platform ?? 'Unknown' }} {{ $visitor->platform_version ?? '' }}</div>
                </div>
                <div class="info-item full-width">
                    <div class="info-label">User Agent</div>
                    <div class="info-value" style="font-size: 12px; word-break: break-all;">{{ $visitor->user_agent ?? 'Unknown' }}</div>
                </div>
            </div>

            <h3 style="margin-top: 25px; margin-bottom: 15px; color: #333;">🔗 Referral & Navigation</h3>
            <div class="info-grid">
                @if($visitor->referrer_domain)
                <div class="info-item">
                    <div class="info-label">Referrer Domain</div>
                    <div class="info-value">{{ $visitor->referrer_domain }}</div>
                </div>
                @endif
                @if($visitor->referrer_url)
                <div class="info-item full-width">
                    <div class="info-label">Referrer URL</div>
                    <div class="info-value" style="font-size: 12px; word-break: break-all;">
                        <a href="{{ $visitor->referrer_url }}" style="color: #667eea;">{{ $visitor->referrer_url }}</a>
                    </div>
                </div>
                @endif
                <div class="info-item full-width">
                    <div class="info-label">Landing Page</div>
                    <div class="info-value" style="font-size: 12px; word-break: break-all;">{{ $visitor->landing_page }}</div>
                </div>
            </div>

            <div class="timestamp">
                <strong>Verified At:</strong> {{ $visitor->verified_at->format('F j, Y g:i A') }} ({{ $visitor->verified_at->diffForHumans() }})
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from FieldEngineer Pro visitor tracking system</p>
        </div>
    </div>
</body>
</html>
