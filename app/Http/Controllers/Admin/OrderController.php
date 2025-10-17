<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->search, function ($query, $search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Transform order data for the frontend
        $orders->transform(function ($order) {
            return [
                'id' => $order->id,
                'customer_name' => $order->user->name,
                'customer_email' => $order->user->email,
                'status' => $order->status,
                'created_at' => $order->created_at,
                'total' => $order->total,
                'payment_method' => $order->payment_method,
                'payment_id' => $order->payment_id,
            ];
        });

        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Inertia\Response
     */
    public function show(Order $order)
    {
        $order->load('user', 'items');
        
        // Add status history to the order
        $order->status_history = $order->statusHistory()->orderBy('created_at', 'desc')->get();
        
        // Add any other necessary data transformations here
        
        return Inertia::render('Admin/Orders/Show', [
            'order' => $order
        ]);
    }

    /**
     * Update the order status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,refunded',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        // Record the status change in history
        $order->statusHistory()->create([
            'status' => $request->status,
            'user_id' => auth()->id(),
            'note' => $request->note ?? null,
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Process a refund for the order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processRefund(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $order->total,
            'reason' => 'required|string|max:500',
        ]);

        // Implement refund logic here (Stripe API call, etc.)
        // This is a placeholder for the actual implementation
        
        // For this example, we'll just update the status
        $order->update([
            'status' => 'refunded',
        ]);

        // Record the refund in history
        $order->statusHistory()->create([
            'status' => 'refunded',
            'user_id' => auth()->id(),
            'note' => 'Refunded $' . number_format($request->amount, 2) . '. Reason: ' . $request->reason,
        ]);

        return redirect()->back()->with('success', 'Refund processed successfully.');
    }
}