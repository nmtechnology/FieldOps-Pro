<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Get authenticated user
        $user = auth()->user();
        
        // Fetch user's orders with products and payments
        $purchases = Order::where('user_id', $user->id)
            ->with(['product', 'payments'])
            ->latest()
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'product' => [
                        'id' => $order->product->id,
                        'name' => $order->product->name,
                        'description' => $order->product->description,
                        'access_url' => $order->product->access_url,
                    ],
                    'total_amount' => $order->total_amount,
                    'status' => $order->status,
                    'purchase_date' => $order->created_at->format('F j, Y'),
                    'payment_status' => $order->payments->isNotEmpty() ? 
                        ($order->payments->first()->status === 'completed' ? 'paid' : 'pending') : 'unpaid',
                ];
            });
        
        return Inertia::render('Dashboard', [
            'purchases' => $purchases,
        ]);
    }
    
    public function accessProduct($productId)
    {
        $user = auth()->user();
        
        // Check if user has purchased this product and payment is completed
        $order = Order::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->whereHas('payments', function ($query) {
                $query->where('status', 'completed');
            })
            ->first();
        
        if (!$order) {
            return redirect()->route('dashboard')->with('error', 'You do not have access to this product.');
        }
        
        // Get product access URL
        $accessUrl = $order->product->access_url;
        
        return Inertia::render('ProductAccess', [
            'product' => $order->product,
            'accessUrl' => $accessUrl,
        ]);
    }
}
