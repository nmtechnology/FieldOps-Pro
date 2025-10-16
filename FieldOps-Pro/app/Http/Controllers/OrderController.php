<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\Refund;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch all orders with related data for admin view
        $orders = Order::with(['user', 'product', 'payments'])
            ->latest()
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'user' => [
                        'id' => $order->user->id,
                        'name' => $order->user->name,
                        'email' => $order->user->email,
                    ],
                    'product' => [
                        'id' => $order->product->id,
                        'name' => $order->product->name,
                    ],
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'created_at' => $order->created_at->format('F j, Y'),
                    'payment' => $order->payments->isNotEmpty() ? [
                        'id' => $order->payments->first()->id,
                        'payment_method' => $order->payments->first()->payment_method,
                        'status' => $order->payments->first()->status,
                        'stripe_payment_id' => $order->payments->first()->stripe_payment_id,
                    ] : null,
                    'refunded' => $order->status === 'refunded',
                ];
            });
        
        return Inertia::render('Admin/Orders', [
            'orders' => $orders
        ]);
    }
    
    public function refund(Request $request, Order $order)
    {
        // Validate request
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);
        
        // Check if order is already refunded
        if ($order->status === 'refunded') {
            return back()->with('error', 'This order has already been refunded.');
        }
        
        // Get payment associated with order
        $payment = $order->payments->first();
        
        if (!$payment || !$payment->stripe_payment_id) {
            return back()->with('error', 'No payment information found for this order.');
        }
        
        try {
            // Configure Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Process refund through Stripe
            $refund = Refund::create([
                'payment_intent' => $payment->stripe_payment_id,
                'reason' => 'requested_by_customer',
            ]);
            
            // Update order status
            $order->status = 'refunded';
            $order->save();
            
            // Update payment status
            $payment->status = 'refunded';
            $payment->refund_id = $refund->id;
            $payment->refund_reason = $request->reason;
            $payment->refunded_at = now();
            $payment->save();
            
            return back()->with('success', 'Refund processed successfully.');
            
        } catch (\Exception $e) {
            Log::error('Refund processing error: ' . $e->getMessage());
            return back()->with('error', 'Unable to process refund: ' . $e->getMessage());
        }
    }
    
    public function show(Order $order)
    {
        // Ensure the user is an admin or the order belongs to the authenticated user
        if (!auth()->user()->is_admin && auth()->id() !== $order->user_id) {
            abort(403);
        }
        
        $orderDetails = [
            'id' => $order->id,
            'user' => [
                'id' => $order->user->id,
                'name' => $order->user->name,
                'email' => $order->user->email,
            ],
            'product' => [
                'id' => $order->product->id,
                'name' => $order->product->name,
                'description' => $order->product->description,
                'price' => $order->product->price,
            ],
            'total_amount' => $order->total_amount,
            'status' => $order->status,
            'created_at' => $order->created_at->format('F j, Y'),
            'payment' => $order->payments->isNotEmpty() ? [
                'id' => $order->payments->first()->id,
                'payment_method' => $order->payments->first()->payment_method,
                'status' => $order->payments->first()->status,
                'stripe_payment_id' => $order->payments->first()->stripe_payment_id,
                'refund_id' => $order->payments->first()->refund_id,
                'refund_reason' => $order->payments->first()->refund_reason,
                'refunded_at' => $order->payments->first()->refunded_at ? 
                    $order->payments->first()->refunded_at->format('F j, Y') : null,
            ] : null,
        ];
        
        return Inertia::render('Admin/OrderDetails', [
            'order' => $orderDetails,
        ]);
    }
}
