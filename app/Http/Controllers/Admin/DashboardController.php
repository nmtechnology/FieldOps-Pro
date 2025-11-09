<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Discount;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Dashboard');
    }

    /**
     * Get dashboard statistics.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('amount');
        $activeUsers = User::where('is_admin', false)->count();
        
        // Get discount statistics
        $activeDiscounts = Discount::where('active', true)->count();
        $inactiveDiscounts = Discount::where('active', false)->count();
        $totalDiscounts = Discount::count();

        // Get recent orders with user names
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'user_name' => $order->user->name ?? 'Guest',
                    'status' => $order->status,
                    'amount' => $order->amount,
                ];
            });

        // Get recently active users
        $onlineUsers = User::orderBy('last_login_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_admin' => $user->is_admin,
                    'is_online' => $user->is_online,
                    'last_login_at' => $user->last_login_at,
                ];
            });

        return response()->json([
            'stats' => [
                'totalOrders' => $totalOrders,
                'pendingOrders' => $pendingOrders,
                'totalRevenue' => (float) $totalRevenue,
                'activeUsers' => $activeUsers,
                'activeDiscounts' => $activeDiscounts,
                'inactiveDiscounts' => $inactiveDiscounts,
                'totalDiscounts' => $totalDiscounts
            ],
            'recentOrders' => $recentOrders,
            'onlineUsers' => $onlineUsers
        ]);
    }
}