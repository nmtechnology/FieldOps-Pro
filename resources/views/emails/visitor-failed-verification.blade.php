<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #111827;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(239, 68, 68, 0.2);
        }
        .header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAwIDEwIEwgNDAgMTAgTSAxMCAwIEwgMTAgNDAgTSAwIDIwIEwgNDAgMjAgTSAyMCAwIEwgMjAgNDAgTSAwIDMwIEwgNDAgMzAgTSAzMCAwIEwgMzAgNDAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS1vcGFjaXR5PSIwLjA1IiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=');
            opacity: 0.3;
        }
        .logo-container {
            position: relative;
            margin-bottom: 15px;
        }
        .logo {
            width: 64px;
            height: 64px;
            margin: 0 auto;
            display: block;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            position: relative;
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
            border-radius: 8px;
            border-left: 4px solid #f97316;
            transition: transform 0.2s;
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
            background: #ef4444;
            color: white;
        }
        .alert-box {
            background: #fef2f2;
            border: 2px solid #fecaca;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #991b1b;
        }
        .footer {
            background: linear-gradient(135deg, #1e293b 0%, #111827 100%);
            padding: 25px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
        .footer-brand {
            color: #f97316;
            font-weight: 700;
            text-decoration: none;
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
            <div class="logo-container">
                <svg class="logo" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="32" cy="32" r="31" fill="#1e293b" stroke="#fff" stroke-width="2"/>
                    <rect x="20" y="14" width="24" height="4" fill="#fff"/>
                    <rect x="18" y="18" width="28" height="2" fill="#f3f4f6"/>
                    <rect x="24" y="12" width="16" height="2" fill="#fff"/>
                    <rect x="22" y="16" width="4" height="2" fill="#fef3c7"/>
                    <rect x="22" y="20" width="20" height="4" fill="#ffd4a3"/>
                    <rect x="20" y="24" width="24" height="8" fill="#ffd4a3"/>
                    <rect x="24" y="28" width="4" height="2" fill="#78350f"/>
                    <rect x="36" y="28" width="4" height="2" fill="#78350f"/>
                    <rect x="22" y="30" width="20" height="2" fill="#78350f"/>
                    <rect x="24" y="24" width="4" height="4" fill="#ffffff"/>
                    <rect x="36" y="24" width="4" height="4" fill="#ffffff"/>
                    <rect x="26" y="26" width="2" height="2" fill="#000000"/>
                    <rect x="38" y="26" width="2" height="2" fill="#000000"/>
                    <rect x="20" y="32" width="24" height="4" fill="#fff"/>
                    <rect x="18" y="36" width="28" height="8" fill="#fff"/>
                    <rect x="24" y="32" width="4" height="12" fill="#dbeafe"/>
                    <rect x="36" y="32" width="4" height="12" fill="#dbeafe"/>
                    <rect x="26" y="34" width="2" height="2" fill="#fbbf24"/>
                    <rect x="38" y="34" width="2" height="2" fill="#fbbf24"/>
                    <rect x="22" y="44" width="20" height="8" fill="#dbeafe"/>
                </svg>
            </div>
            <h1>⚠️ Failed Verification Attempt</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.95; position: relative;">A visitor failed the math verification on <strong>FieldEngineer Pro</strong></p>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <strong>⚠️ Failed Attempt:</strong> This visitor submitted an incorrect answer to the math verification.
                <br><strong>Attempts Made:</strong> {{ $attempts }}
            </div>
            
            <p><span class="badge">SUSPICIOUS ACTIVITY</span></p>
            
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
                        <a href="{{ $visitor->referrer_url }}" style="color: #f97316; text-decoration: none;">{{ $visitor->referrer_url }}</a>
                    </div>
                </div>
                @endif
                <div class="info-item full-width">
                    <div class="info-label">Landing Page</div>
                    <div class="info-value" style="font-size: 12px; word-break: break-all;">{{ $visitor->landing_page }}</div>
                </div>
            </div>

            <div class="timestamp">
                <strong>Attempted At:</strong> {{ now()->format('F j, Y g:i A') }} ({{ now()->diffForHumans() }})
            </div>
        </div>
        
        <div class="footer">
            <p style="margin: 0 0 10px 0;">This is an automated notification from <a href="https://fieldengineerpro.com" class="footer-brand">FieldEngineer Pro</a></p>
            <p style="margin: 0; font-size: 11px; opacity: 0.7;">© 2026 FieldEngineer Pro. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
