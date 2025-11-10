<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion - {{ $user->name }}</title>
    <style>
        @page {
            size: landscape;
            margin: 0;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .certificate {
            width: 11in;
            height: 8.5in;
            padding: 40px;
            box-sizing: border-box;
            background: white;
            border: 20px solid #f97316;
            position: relative;
            margin: 0 auto;
        }
        
        .certificate::before {
            content: '';
            position: absolute;
            top: 30px;
            left: 30px;
            right: 30px;
            bottom: 30px;
            border: 3px solid #fb923c;
        }
        
        .certificate-content {
            text-align: center;
            position: relative;
            z-index: 1;
            padding-top: 40px;
        }
        
        .logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
            image-rendering: pixelated;
        }
        
        .certificate-title {
            font-size: 48px;
            color: #1f2937;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .divider {
            width: 200px;
            height: 4px;
            background: #f97316;
            margin: 20px auto;
        }
        
        .certifies-text {
            font-size: 24px;
            color: #6b7280;
            margin: 30px 0 10px;
        }
        
        .recipient-name {
            font-size: 56px;
            color: #f97316;
            font-weight: bold;
            margin: 20px 0;
            font-family: 'Brush Script MT', cursive;
        }
        
        .completion-text {
            font-size: 24px;
            color: #6b7280;
            margin: 20px 0;
        }
        
        .course-title {
            font-size: 36px;
            color: #1f2937;
            font-weight: bold;
            margin: 20px 0 30px;
        }
        
        .description {
            font-size: 18px;
            color: #6b7280;
            max-width: 800px;
            margin: 30px auto;
            line-height: 1.6;
        }
        
        .signatures {
            display: flex;
            justify-content: space-around;
            max-width: 700px;
            margin: 50px auto 0;
        }
        
        .signature-block {
            text-align: center;
        }
        
        .signature-line {
            border-top: 2px solid #374151;
            width: 250px;
            padding-top: 10px;
            margin-top: 40px;
        }
        
        .signature-title {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
        }
        
        .signature-subtitle {
            font-size: 14px;
            color: #6b7280;
        }
        
        .score-badge {
            position: absolute;
            top: 60px;
            right: 60px;
            background: #10b981;
            color: white;
            padding: 15px 25px;
            border-radius: 50%;
            font-size: 20px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .certificate-id {
            position: absolute;
            bottom: 50px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
        
        @media print {
            body {
                background: white;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; padding: 20px; background: #1f2937; color: white;">
        <button onclick="window.print()" style="padding: 15px 30px; font-size: 18px; background: #f97316; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
            🖨️ Print/Save Certificate
        </button>
    </div>
    
    <div class="certificate">
        <div class="score-badge">
            {{ $completion->score }}%
        </div>
        
        <div class="certificate-content">
            <img src="{{ asset('img/8bit-character.svg') }}" alt="FieldOps Pro" class="logo">
            
            <div class="certificate-title">Certificate of Completion</div>
            
            <div class="divider"></div>
            
            <div class="certifies-text">This certifies that</div>
            
            <div class="recipient-name">{{ $user->name }}</div>
            
            <div class="completion-text">has successfully completed</div>
            
            <div class="course-title">{{ $product->name }}</div>
            
            <div class="description">
                Demonstrating proficiency in platform navigation, professional service delivery,
                business operations, pricing strategies, territory management, and independent contractor best practices
                for building a successful field technician business.
            </div>
            
            <div class="signatures">
                <div class="signature-block">
                    <div class="signature-line">
                        <div class="signature-title">FieldOps Pro</div>
                        <div class="signature-subtitle">Training Program</div>
                    </div>
                </div>
                <div class="signature-block">
                    <div class="signature-line">
                        <div class="signature-title">{{ $completion->completed_at->format('F j, Y') }}</div>
                        <div class="signature-subtitle">Date of Completion</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="certificate-id">
            Certificate ID: FOP-{{ strtoupper(substr(md5($user->id . $product->id . $completion->completed_at), 0, 12)) }}
        </div>
    </div>
</body>
</html>
