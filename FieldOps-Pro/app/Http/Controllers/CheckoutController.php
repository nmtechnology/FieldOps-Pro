<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page for a product
     */
    public function checkout(Request $request, Product $product)
    {
        return Inertia::render('Checkout', [
            'product' => $product,
            'stripeKey' => config('services.stripe.key'),
        ]);
    }
    
    /**
     * Process the payment and create the order
     */
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_code' => 'nullable|string',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        $user = $request->user();
        
        // Calculate price with discount if applicable
        $discountAmount = 0;
        $finalPrice = $product->price;
        $discount = null;
        
        if (!empty($validated['discount_code'])) {
            $discount = Discount::where('code', $validated['discount_code'])
                ->where('is_active', true)
                ->first();
                
            if ($discount) {
                // Check if discount is valid
                $isValid = true;
                
                // Check date validity
                if ($discount->valid_from && $discount->valid_from > now()) {
                    $isValid = false;
                }
                
                if ($discount->valid_until && $discount->valid_until < now()) {
                    $isValid = false;
                }
                
                // Check usage limit
                if ($discount->max_uses && $discount->usage_count >= $discount->max_uses) {
                    $isValid = false;
                }
                
                if ($isValid) {
                    if ($discount->type === 'percentage') {
                        $discountAmount = $product->price * ($discount->value / 100);
                    } else {
                        $discountAmount = $discount->value;
                    }
                    
                    $finalPrice = $product->price - $discountAmount;
                    if ($finalPrice < 0) {
                        $finalPrice = 0;
                    }
                    
                    // Increment the usage count
                    $discount->usage_count += 1;
                    $discount->save();
                }
            }
        }
        
        // Create the order
        $order = new Order([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => $finalPrice,
            'status' => 'pending',
            'order_number' => 'ORD-' . Str::random(10),
        ]);
        
        if ($discount) {
            $order->discount_id = $discount->id;
            $order->discount_amount = $discountAmount;
        }
        
        $order->save();
        
        try {
            // Set your Stripe secret key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            if ($finalPrice > 0) {
                // Create a payment intent
                $intent = PaymentIntent::create([
                    'amount' => (int)($finalPrice * 100), // Amount in cents
                    'currency' => 'usd',
                    'metadata' => [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                    ],
                ]);
                
                // Create a payment record
                $payment = new Payment([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'payment_method' => 'card',
                    'stripe_payment_id' => $intent->id,
                    'status' => 'pending',
                    'amount' => $finalPrice,
                    'currency' => 'USD',
                ]);
                
                $payment->save();
                
                // Return the client secret to the frontend
                return response()->json([
                    'client_secret' => $intent->client_secret,
                    'order_id' => $order->id
                ]);
            } else {
                // If the price is 0 (100% discount), mark as completed right away
                $order->status = 'completed';
                $order->save();
                
                $payment = new Payment([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'payment_method' => 'discount',
                    'status' => 'completed',
                    'amount' => 0,
                    'currency' => 'USD',
                    'paid_at' => now(),
                ]);
                
                $payment->save();
                
                return response()->json([
                    'success' => true,
                    'order_id' => $order->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Payment error: ' . $e->getMessage());
            
            // Update order status to failed
            $order->status = 'failed';
            $order->save();
            
            return response()->json(['error' => 'Payment failed: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Process ACH payment (bank transfer)
     */
    public function processAchPayment(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'routing_number' => 'required|string',
            'account_number' => 'required|string',
            'discount_code' => 'nullable|string',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        $user = $request->user();
        
        // Calculate price with discount if applicable
        $discountAmount = 0;
        $finalPrice = $product->price;
        $discount = null;
        
        if (!empty($validated['discount_code'])) {
            $discount = Discount::where('code', $validated['discount_code'])
                ->where('is_active', true)
                ->first();
                
            if ($discount) {
                // Check if discount is valid
                $isValid = true;
                
                // Check date validity
                if ($discount->valid_from && $discount->valid_from > now()) {
                    $isValid = false;
                }
                
                if ($discount->valid_until && $discount->valid_until < now()) {
                    $isValid = false;
                }
                
                // Check usage limit
                if ($discount->max_uses && $discount->usage_count >= $discount->max_uses) {
                    $isValid = false;
                }
                
                if ($isValid) {
                    if ($discount->type === 'percentage') {
                        $discountAmount = $product->price * ($discount->value / 100);
                    } else {
                        $discountAmount = $discount->value;
                    }
                    
                    $finalPrice = $product->price - $discountAmount;
                    if ($finalPrice < 0) {
                        $finalPrice = 0;
                    }
                    
                    // Increment the usage count
                    $discount->usage_count += 1;
                    $discount->save();
                }
            }
        }
        
        // Create the order
        $order = new Order([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'total_amount' => $finalPrice,
            'status' => 'pending',
            'order_number' => 'ORD-' . Str::random(10),
        ]);
        
        if ($discount) {
            $order->discount_id = $discount->id;
            $order->discount_amount = $discountAmount;
        }
        
        $order->save();
        
        try {
            // Set your Stripe secret key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Create an ACH payment using Stripe
            // Note: This is a simplified implementation - production code would require more verification steps
            $bankAccount = [
                'country' => 'US',
                'currency' => 'usd',
                'account_holder_name' => $validated['name'],
                'account_holder_type' => 'individual',
                'routing_number' => $validated['routing_number'],
                'account_number' => $validated['account_number'],
            ];
            
            // Create a customer in Stripe
            $customer = \Stripe\Customer::create([
                'email' => $validated['email'],
                'name' => $validated['name'],
            ]);
            
            // Attach the bank account to the customer
            $bankToken = \Stripe\Token::create(['bank_account' => $bankAccount]);
            $bankAccount = \Stripe\Customer::createSource(
                $customer->id,
                ['source' => $bankToken->id]
            );
            
            // Create a payment intent for ACH
            $intent = \Stripe\PaymentIntent::create([
                'amount' => (int)($finalPrice * 100),
                'currency' => 'usd',
                'payment_method_types' => ['us_bank_account'],
                'customer' => $customer->id,
                'payment_method' => $bankAccount->id,
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                ],
                // ACH payments usually require confirmation later
                'confirm' => false,
            ]);
            
            // Create a payment record
            $payment = new Payment([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'payment_method' => 'ach',
                'stripe_payment_id' => $intent->id,
                'status' => 'pending',
                'amount' => $finalPrice,
                'currency' => 'USD',
            ]);
            
            $payment->save();
            
            // Return the order ID
            return response()->json([
                'success' => true,
                'order_id' => $order->id
            ]);
            
        } catch (\Exception $e) {
            Log::error('ACH Payment error: ' . $e->getMessage());
            
            // Update order status to failed
            $order->status = 'failed';
            $order->save();
            
            return response()->json(['error' => 'ACH Payment failed: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Show the thank you page after successful purchase
     */
    public function thankYou(Order $order)
    {
        // Ensure the order belongs to the current user for security
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $orderData = [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'total_amount' => $order->total_amount,
            'status' => $order->status,
            'created_at' => $order->created_at->format('F j, Y'),
            'product' => [
                'id' => $order->product->id,
                'name' => $order->product->name,
                'description' => $order->product->description,
            ],
            'payment' => $order->payments->isNotEmpty() ? [
                'status' => $order->payments->first()->status,
                'payment_method' => $order->payments->first()->payment_method,
            ] : null
        ];
        
        return Inertia::render('ThankYou', [
            'order' => $orderData
        ]);
    }
}
