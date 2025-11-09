<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px; }
        .order-summary { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .product-box { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 20px; margin: 20px 0; border-radius: 4px; }
        .button { display: inline-block; background: #ea580c; color: white; padding: 15px 40px; text-decoration: none; border-radius: 6px; margin: 20px 0; font-weight: bold; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .total { font-size: 18px; font-weight: bold; color: #ea580c; margin-top: 10px; padding-top: 10px; border-top: 2px solid #ea580c; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">✅ Purchase Confirmed!</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Thank you for your purchase</p>
        </div>
        
        <div class="content">
            <p>Hi {{ $order->user->name ?? 'there' }},</p>
            
            <p>Thank you for purchasing <strong>{{ $order->product->name }}</strong>! Your order has been confirmed and you now have full access to your content.</p>
            
            <div class="product-box">
                <h3 style="margin-top: 0; color: #92400e;">🎯 Access Your Purchase</h3>
                <p style="margin-bottom: 0;">Click the button below to access your product and start learning:</p>
            </div>
            
            <center>
                <a href="{{ route('products.content.show', [$order->product, $order->product->publishedContents->first() ?? 1]) }}" class="button">
                    Access Your Content Now →
                </a>
            </center>
            
            <div class="order-summary">
                <h3 style="margin-top: 0; color: #111827;">Order Summary</h3>
                
                <div class="detail-row">
                    <span>Order Number:</span>
                    <span><strong>#{{ $order->order_number }}</strong></span>
                </div>
                
                <div class="detail-row">
                    <span>Product:</span>
                    <span>{{ $order->product->name }}</span>
                </div>
                
                <div class="detail-row">
                    <span>Date:</span>
                    <span>{{ $order->created_at->format('M d, Y g:i A') }}</span>
                </div>
                
                @if($order->discount_amount > 0)
                <div class="detail-row">
                    <span>Original Price:</span>
                    <span>${{ number_format($order->amount + $order->discount_amount, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span>Discount:</span>
                    <span style="color: #10b981;">-${{ number_format($order->discount_amount, 2) }}</span>
                </div>
                @endif
                
                <div class="total">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Total Paid:</span>
                        <span>${{ number_format($order->amount, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div style="background: #dbeafe; border-left: 4px solid #3b82f6; padding: 15px; margin-top: 20px; border-radius: 4px;">
                <h4 style="margin: 0 0 10px 0; color: #1e40af;">Need Help?</h4>
                <p style="margin: 0;">If you have any questions or issues accessing your content, our support team is here to help!</p>
                <p style="margin: 10px 0 0 0;">
                    <a href="{{ route('contact') }}" style="color: #2563eb; text-decoration: none; font-weight: bold;">Contact Support →</a>
                </p>
            </div>
            
            <p style="margin-top: 30px;">Best regards,<br><strong>The FieldEngineer Pro Team</strong></p>
        </div>
        
        <div class="footer">
            <p>This email was sent to {{ $order->user->email ?? 'your email' }}</p>
            <p>Order #{{ $order->order_number }} | {{ config('app.url') }}</p>
        </div>
    </div>
</body>
</html>
