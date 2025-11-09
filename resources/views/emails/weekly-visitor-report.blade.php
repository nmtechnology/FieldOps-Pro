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
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 30px;
            background: #f8f9fa;
        }
        .stat-card {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        .list-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            background: #f8f9fa;
            margin-bottom: 8px;
            border-radius: 4px;
        }
        .list-label {
            font-weight: 500;
            color: #333;
        }
        .list-value {
            color: #667eea;
            font-weight: 600;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        tr:hover {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Weekly Visitor Report</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">{{ $stats['period_start'] }} to {{ $stats['period_end'] }}</p>
        </div>
        
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-number">{{ number_format($stats['total_visitors']) }}</div>
                <div class="stat-label">Total Visitors</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ number_format($stats['verified_visitors']) }}</div>
                <div class="stat-label">Verified</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['verification_rate'] }}%</div>
                <div class="stat-label">Verification Rate</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['top_countries']->count() }}</div>
                <div class="stat-label">Countries</div>
            </div>
        </div>
        
        <div class="content">
            @if($stats['top_countries']->isNotEmpty())
            <div class="section">
                <div class="section-title">🌍 Top Countries</div>
                @foreach($stats['top_countries']->take(10) as $country => $count)
                <div class="list-item">
                    <span class="list-label">{{ $country ?: 'Unknown' }}</span>
                    <span class="list-value">{{ $count }} visitors</span>
                </div>
                @endforeach
            </div>
            @endif

            @if($stats['top_referrers']->isNotEmpty())
            <div class="section">
                <div class="section-title">🔗 Top Referrer Domains</div>
                @foreach($stats['top_referrers']->take(10) as $domain => $count)
                <div class="list-item">
                    <span class="list-label">{{ $domain }}</span>
                    <span class="list-value">{{ $count }} referrals</span>
                </div>
                @endforeach
            </div>
            @endif

            <div class="section">
                <div class="section-title">💻 Device Breakdown</div>
                @foreach($stats['device_breakdown'] as $device => $count)
                <div class="list-item">
                    <span class="list-label">{{ ucfirst($device) }}</span>
                    <span class="list-value">{{ $count }} ({{ round(($count / $stats['verified_visitors']) * 100, 1) }}%)</span>
                </div>
                @endforeach
            </div>

            @if($stats['browser_breakdown']->isNotEmpty())
            <div class="section">
                <div class="section-title">🌐 Top Browsers</div>
                @foreach($stats['browser_breakdown'] as $browser => $count)
                <div class="list-item">
                    <span class="list-label">{{ $browser ?: 'Unknown' }}</span>
                    <span class="list-value">{{ $count }}</span>
                </div>
                @endforeach
            </div>
            @endif

            @if($stats['platform_breakdown']->isNotEmpty())
            <div class="section">
                <div class="section-title">⚙️ Operating Systems</div>
                @foreach($stats['platform_breakdown'] as $platform => $count)
                <div class="list-item">
                    <span class="list-label">{{ $platform ?: 'Unknown' }}</span>
                    <span class="list-value">{{ $count }}</span>
                </div>
                @endforeach
            </div>
            @endif

            @if($visitors->isNotEmpty())
            <div class="section">
                <div class="section-title">📋 Recent Verified Visitors (Last 20)</div>
                <table>
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Location</th>
                            <th>IP Address</th>
                            <th>Device</th>
                            <th>Referrer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visitors->sortByDesc('verified_at')->take(20) as $visitor)
                        <tr>
                            <td>{{ $visitor->verified_at->format('M j, g:i A') }}</td>
                            <td>{{ $visitor->city ? $visitor->city . ', ' : '' }}{{ $visitor->country ?? 'Unknown' }}</td>
                            <td>{{ $visitor->ip_address }}</td>
                            <td>{{ ucfirst($visitor->device_type ?? 'Unknown') }}</td>
                            <td>{{ $visitor->referrer_domain ?? 'Direct' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        
        <div class="footer">
            <p><strong>FieldEngineer Pro</strong> - Weekly Visitor Analytics Report</p>
            <p>Report generated on {{ now()->format('F j, Y g:i A') }}</p>
        </div>
    </div>
</body>
</html>
