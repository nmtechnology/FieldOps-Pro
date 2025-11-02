<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Services\CoinbaseCommerceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoinbasePaymentController extends Controller
{
    protected CoinbaseCommerceService $coinbase;

    public function __construct(CoinbaseCommerceService $coinbase)
    {
        $this->coinbase = $coinbase;
    }

    /**
     * Create Coinbase Commerce charge for authenticated user
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_code' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $finalPrice = $product->price;
        $discountAmount = 0;

        // Handle discount code (similar to CheckoutController)
        if (!empty($validated['discount_code'])) {
            $discount = \App\Models\Discount::where('code', $validated['discount_code'])
                ->where('active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })
                ->first();

            if ($discount) {
                if ($discount->type === 'percentage') {
                    $discountAmount = ($product->price * $discount->value) / 100;
                } else {
                    $discountAmount = $discount->value;
                }
                $finalPrice -= $discountAmount;
            }
        }

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'amount' => $finalPrice,
            'status' => 'pending',
            'order_number' => 'ORD-' . strtoupper(uniqid()),
        ]);

        // Create Coinbase Commerce charge
        $charge = $this->coinbase->createCharge([
            'name' => $product->name,
            'description' => $product->description,
            'pricing_type' => 'fixed_price',
            'local_price' => [
                'amount' => number_format($finalPrice, 2, '.', ''),
                'currency' => 'USD',
            ],
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ],
            'redirect_url' => route('thank-you', ['order' => $order->order_number]),
            'cancel_url' => route('products'),
        ]);

        if (!$charge) {
            $order->delete();
            return back()->with('error', 'Failed to create payment. Please try again.');
        }

        // Create pending payment record
        Payment::create([
            'order_id' => $order->id,
            'amount' => $finalPrice,
            'payment_method' => 'coinbase',
            'status' => 'pending',
            'transaction_id' => $charge['id'],
        ]);

        // Redirect to Coinbase Commerce hosted page
        return Inertia::location($charge['hosted_url']);
    }

    /**
     * Create Coinbase Commerce charge for guest user
     */
    public function guestCheckout(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'email' => 'required|email',
            'discount_code' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $finalPrice = $product->price;
        $discountAmount = 0;

        // Handle discount code
        if (!empty($validated['discount_code'])) {
            $discount = \App\Models\Discount::where('code', $validated['discount_code'])
                ->where('active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })
                ->first();

            if ($discount) {
                if ($discount->type === 'percentage') {
                    $discountAmount = ($product->price * $discount->value) / 100;
                } else {
                    $discountAmount = $discount->value;
                }
                $finalPrice -= $discountAmount;
            }
        }

        // Create guest order
        $order = Order::create([
            'user_id' => null,
            'product_id' => $product->id,
            'amount' => $finalPrice,
            'status' => 'pending',
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'guest_email' => $validated['email'],
        ]);

        // Create Coinbase Commerce charge
        $charge = $this->coinbase->createCharge([
            'name' => $product->name,
            'description' => $product->description,
            'pricing_type' => 'fixed_price',
            'local_price' => [
                'amount' => number_format($finalPrice, 2, '.', ''),
                'currency' => 'USD',
            ],
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'guest_email' => $validated['email'],
                'product_id' => $product->id,
            ],
            'redirect_url' => route('guest.thank-you', ['order' => $order->order_number]),
            'cancel_url' => route('products'),
        ]);

        if (!$charge) {
            $order->delete();
            return back()->with('error', 'Failed to create payment. Please try again.');
        }

        // Create pending payment record
        Payment::create([
            'order_id' => $order->id,
            'amount' => $finalPrice,
            'payment_method' => 'coinbase',
            'status' => 'pending',
            'transaction_id' => $charge['id'],
        ]);

        // Redirect to Coinbase Commerce hosted page
        return Inertia::location($charge['hosted_url']);
    }
}
