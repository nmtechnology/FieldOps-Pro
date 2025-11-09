<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px; }
        .order-details { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #ea580c; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
        .detail-label { font-weight: bold; color: #6b7280; }
        .detail-value { color: #111827; }
        .total { font-size: 20px; font-weight: bold; color: #ea580c; margin-top: 15px; padding-top: 15px; border-top: 2px solid #ea580c; }
        .button { display: inline-block; background: #ea580c; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">🎉 New Order Received!</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Order #{{ $order->order_number }}</p>
        </div>
        
        <div class="content">
            <p>Great news! You've received a new order on FieldEngineer Pro.</p>
            
            <div class="order-details">
                <h2 style="margin-top: 0; color: #111827;">Order Details</h2>
                
                <div class="detail-row">
                    <span class="detail-label">Customer:</span>
                    <span class="detail-value">{{ $order->user->name ?? 'Guest' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $order->user->email ?? 'N/A' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Product:</span>
                    <span class="detail-value">{{ $order->product->name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" style="text-transform: capitalize;">{{ $order->status }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ $order->created_at->format('M d, Y g:i A') }}</span>
                </div>
                
                @if($order->discount_amount > 0)
                <div class="detail-row">
                    <span class="detail-label">Discount Applied:</span>
                    <span class="detail-value" style="color: #10b981;">-${{ number_format($order->discount_amount, 2) }}</span>
                </div>
                @endif
                
                <div class="total">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Total Amount:</span>
                        <span>${{ number_format($order->amount, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <center>
                <a href="{{ route('admin.orders.show', $order) }}" class="button">View Order in Admin</a>
            </center>
            
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin-top: 20px; border-radius: 4px;">
                <strong>📌 Quick Action:</strong> Make sure the customer has access to their purchased content!
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated notification from FieldEngineer Pro</p>
            <p>{{ config('app.url') }}</p>
        </div>
    </div>
</body>
</html>
