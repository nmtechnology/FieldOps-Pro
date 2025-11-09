<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px; }
        .request-box { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #3b82f6; }
        .field { margin-bottom: 15px; }
        .field-label { font-weight: bold; color: #6b7280; display: block; margin-bottom: 5px; }
        .field-value { color: #111827; background: #f3f4f6; padding: 10px; border-radius: 4px; }
        .message-box { background: #f3f4f6; padding: 15px; border-radius: 4px; white-space: pre-wrap; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">💬 New Support Request</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Customer needs assistance</p>
        </div>
        
        <div class="content">
            <p>You've received a new support request from a customer:</p>
            
            <div class="request-box">
                <div class="field">
                    <span class="field-label">From:</span>
                    <div class="field-value">{{ $name }}</div>
                </div>
                
                <div class="field">
                    <span class="field-label">Email:</span>
                    <div class="field-value">
                        <a href="mailto:{{ $email }}" style="color: #2563eb; text-decoration: none;">{{ $email }}</a>
                    </div>
                </div>
                
                <div class="field">
                    <span class="field-label">Subject:</span>
                    <div class="field-value">{{ $subject }}</div>
                </div>
                
                <div class="field">
                    <span class="field-label">Message:</span>
                    <div class="message-box">{{ $message }}</div>
                </div>
            </div>
            
            <div style="background: #dbeafe; border-left: 4px solid #3b82f6; padding: 15px; margin-top: 20px; border-radius: 4px;">
                <strong>💡 Quick Tip:</strong> Reply directly to this email to respond to {{ $name }}. Your reply will go to {{ $email }}.
            </div>
        </div>
        
        <div class="footer">
            <p>Support request received via FieldEngineer Pro contact form</p>
            <p>{{ now()->format('M d, Y g:i A') }}</p>
        </div>
    </div>
</body>
</html>
