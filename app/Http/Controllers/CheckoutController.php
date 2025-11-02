<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Discount;
use App\Services\TaxService;
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
    protected $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    /**
     * Show the checkout page for a product for authenticated users
     */
    public function checkout(Request $request, Product $product)
    {
        return Inertia::render('Checkout', [
            'product' => $product,
            'stripeKey' => config('services.stripe.key'),
            'states' => $this->taxService->getStateNames(),
        ]);
    }
    
    /**
     * Show the checkout page for a product for guest users
     */
    public function guestCheckout(Request $request, Product $product)
    {
        // Store the product ID in the session for later
        session(['guest_checkout_product' => $product->id]);
        
        return Inertia::render('GuestCheckout', [
            'product' => $product,
            'stripeKey' => config('services.stripe.key'),
            'states' => $this->taxService->getStateNames(),
        ]);
    }
    
    /**
     * Calculate tax for a product based on state
     */
    public function calculateTax(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'state' => 'nullable|string|size:2',
            'discount_code' => 'nullable|string',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        $price = $product->price;
        
        // Apply discount if provided
        $discountAmount = 0;
        if (!empty($validated['discount_code'])) {
            $discount = Discount::where('code', $validated['discount_code'])
                ->where('is_active', true)
                ->first();
                
            if ($discount && $this->isDiscountValid($discount)) {
                if ($discount->type === 'percentage') {
                    $discountAmount = $price * ($discount->value / 100);
                } else {
                    $discountAmount = $discount->value;
                }
                
                $price = $price - $discountAmount;
                if ($price < 0) {
                    $price = 0;
                }
            }
        }
        
        // Calculate tax
        $taxCalculation = $this->taxService->calculateTax($price, $validated['state'] ?? null);
        
        return response()->json([
            'subtotal' => $price,
            'tax_rate' => $taxCalculation['tax_rate'],
            'tax_amount' => $taxCalculation['tax_amount'],
            'total' => $taxCalculation['total'],
            'discount_amount' => $discountAmount,
        ]);
    }
    
    /**
     * Check if a discount is valid
     */
    private function isDiscountValid($discount)
    {
        // Check date validity
        if ($discount->valid_from && $discount->valid_from > now()) {
            return false;
        }
        
        if ($discount->valid_until && $discount->valid_until < now()) {
            return false;
        }
        
        // Check usage limit
        if ($discount->max_uses && $discount->usage_count >= $discount->max_uses) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Process the payment and create the order for authenticated users
     */
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_code' => 'nullable|string',
            'state' => 'required|string|size:2',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        $user = $request->user();
        
        // Calculate price with discount if applicable
        $discountAmount = 0;
        $subtotal = $product->price;
        $discount = null;
        
        if (!empty($validated['discount_code'])) {
            $discount = Discount::where('code', $validated['discount_code'])
                ->where('is_active', true)
                ->first();
                
            if ($discount && $this->isDiscountValid($discount)) {
                if ($discount->type === 'percentage') {
                    $discountAmount = $product->price * ($discount->value / 100);
                } else {
                    $discountAmount = $discount->value;
                }
                
                $subtotal = $product->price - $discountAmount;
                if ($subtotal < 0) {
                    $subtotal = 0;
                }
                
                // Increment the usage count
                $discount->usage_count += 1;
                $discount->save();
            }
        }
        
        // Calculate tax
        $taxCalculation = $this->taxService->calculateTax($subtotal, $validated['state']);
        
        // Create the order
        $order = new Order([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => $taxCalculation['total'], // Total including tax
            'subtotal' => $taxCalculation['subtotal'],
            'tax_rate' => $taxCalculation['tax_rate'],
            'tax_amount' => $taxCalculation['tax_amount'],
            'buyer_state' => strtoupper($validated['state']),
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
            
            $totalAmount = $taxCalculation['total'];
            
            if ($totalAmount > 0) {
                // Create a payment intent
                $intent = PaymentIntent::create([
                    'amount' => (int)($totalAmount * 100), // Amount in cents (includes tax)
                    'currency' => 'usd',
                    'metadata' => [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'subtotal' => $taxCalculation['subtotal'],
                        'tax_amount' => $taxCalculation['tax_amount'],
                        'tax_rate' => $taxCalculation['tax_rate'],
                        'buyer_state' => $validated['state'],
                    ],
                ]);
                
                // Create a payment record
                $payment = new Payment([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'payment_method' => 'card',
                    'stripe_payment_id' => $intent->id,
                    'status' => 'pending',
                    'amount' => $totalAmount,
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
    
    /**
     * Process payment for guest users
     */
    public function processGuestPayment(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'payment_method_id' => 'required|string',
            'email' => 'required|email',
            'state' => 'required|string|size:2',
            'discount_code' => 'nullable|string',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        
        // Calculate price with discount if applicable
        $discountAmount = 0;
        $subtotal = $product->price;
        $discount = null;
        
        if (!empty($validated['discount_code'])) {
            $discount = Discount::where('code', $validated['discount_code'])
                ->where('is_active', true)
                ->first();
                
            if ($discount && $this->isDiscountValid($discount)) {
                if ($discount->type === 'percentage') {
                    $discountAmount = $product->price * ($discount->value / 100);
                } else {
                    $discountAmount = $discount->value;
                }
                
                $subtotal = $product->price - $discountAmount;
                if ($subtotal < 0) {
                    $subtotal = 0;
                }
                
                // Increment the usage count
                $discount->usage_count += 1;
                $discount->save();
            }
        }
        
        // Calculate tax
        $taxCalculation = $this->taxService->calculateTax($subtotal, $validated['state']);
        $taxRate = $taxCalculation['tax_rate'];
        $taxAmount = $taxCalculation['tax_amount'];
        $totalAmount = $taxCalculation['total'];
        
        // Setup Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
        
        try {
            // Create a temporary guest order in the session
            $orderNumber = 'GUEST-' . Str::random(10);
            
            // Create a payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100, // Stripe uses cents
                'currency' => 'usd',
                'payment_method' => $validated['payment_method_id'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'metadata' => [
                    'product_id' => $product->id,
                    'order_number' => $orderNumber,
                    'guest_email' => $validated['email'],
                    'buyer_state' => $validated['state'],
                    'subtotal' => $subtotal,
                    'tax_rate' => $taxRate,
                    'tax_amount' => $taxAmount,
                ],
            ]);
            
            // Store guest purchase info in session
            session([
                'guest_purchase' => [
                    'email' => $validated['email'],
                    'product_id' => $product->id,
                    'amount' => $totalAmount,
                    'subtotal' => $subtotal,
                    'tax_rate' => $taxRate,
                    'tax_amount' => $taxAmount,
                    'buyer_state' => $validated['state'],
                    'order_number' => $orderNumber,
                    'payment_intent_id' => $paymentIntent->id,
                    'payment_method_id' => $validated['payment_method_id'],
                    'discount_amount' => $discountAmount,
                    'discount_id' => $discount ? $discount->id : null,
                ]
            ]);
            
            return redirect()->route('guest.thank-you');
        } catch (ApiErrorException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Thank you page for guest users after successful purchase
     */
    public function guestThankYou()
    {
        // Check if guest purchase data exists in session
        if (!session()->has('guest_purchase')) {
            return redirect()->route('home');
        }
        
        $guestPurchase = session('guest_purchase');
        
        // Get product information
        $product = Product::find($guestPurchase['product_id']);
        
        return Inertia::render('GuestThankYou', [
            'purchase' => $guestPurchase,
            'product' => $product,
            'registrationUrl' => route('guest.complete-registration')
        ]);
    }
    
    /**
     * Show form to complete registration after purchase
     */
    public function completeRegistration()
    {
        // Check if guest purchase data exists in session
        if (!session()->has('guest_purchase')) {
            return redirect()->route('home');
        }
        
        $guestPurchase = session('guest_purchase');
        
        return Inertia::render('Auth/CompleteRegistration', [
            'email' => $guestPurchase['email']
        ]);
    }
    
    /**
     * Register user after purchase and associate the order
     */
    public function registerAfterPurchase(Request $request)
    {
        // Check if guest purchase data exists in session
        if (!session()->has('guest_purchase')) {
            return redirect()->route('home');
        }
        
        $guestPurchase = session('guest_purchase');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
        ]);
        
        // Create the user
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $guestPurchase['email'],
            'password' => bcrypt($validated['password']),
        ]);
        
        // Create order for the new user
        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $guestPurchase['product_id'],
            'total_amount' => $guestPurchase['amount'],
            'subtotal' => $guestPurchase['subtotal'] ?? $guestPurchase['amount'],
            'tax_rate' => $guestPurchase['tax_rate'] ?? 0,
            'tax_amount' => $guestPurchase['tax_amount'] ?? 0,
            'buyer_state' => $guestPurchase['buyer_state'] ?? null,
            'discount_id' => $guestPurchase['discount_id'] ?? null,
            'discount_amount' => $guestPurchase['discount_amount'] ?? 0,
            'status' => 'completed',
            'order_number' => $guestPurchase['order_number'],
        ]);
        
        // Create payment record
        Payment::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'amount' => $guestPurchase['amount'],
            'payment_method' => 'stripe',
            'stripe_payment_id' => $guestPurchase['payment_intent_id'],
            'status' => 'completed',
            'currency' => 'USD'
        ]);
        
        // Clear the guest purchase from session
        session()->forget('guest_purchase');
        
        // Log the user in
        auth()->login($user);
        
        // Redirect to dashboard
        return redirect()->route('dashboard');
    }
}
