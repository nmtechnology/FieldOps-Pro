<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Display the main reports page.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Get some summary stats
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('amount'),
            'total_users' => User::count(),
            'total_products' => Product::count(),
        ];
        
        // Get recent orders
        $recentOrders = Order::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();
            
        return Inertia::render('Admin/Reports/Index', [
            'stats' => $stats,
            'recentOrders' => $recentOrders
        ]);
    }

    /**
     * Display sales reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function sales(Request $request)
    {
        // Get date range from request or default to current month
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        
        // Get sales by day
        $salesByDay = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(amount) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Get sales by product
        $salesByProduct = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->select(
                'product_id',
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(amount) as revenue')
            )
            ->with('product:id,name')
            ->groupBy('product_id')
            ->orderByDesc('revenue')
            ->get();
            
        return Inertia::render('Admin/Reports/Sales', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'salesByDay' => $salesByDay,
            'salesByProduct' => $salesByProduct,
            'totalRevenue' => $salesByDay->sum('revenue'),
            'totalOrders' => $salesByDay->sum('orders')
        ]);
    }

    /**
     * Display customer reports.
     *
     * @return \Inertia\Response
     */
    public function customers()
    {
        // Get top customers by revenue
        $topCustomers = User::select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.amount) as total_spent')
            )
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.status', 'completed')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_spent')
            ->take(10)
            ->get();
            
        // Get new customers per month
        $newCustomers = User::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // Get customer retention data (users who have made more than one order)
        $repeatedCustomers = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as order_count')
            )
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.status', 'completed')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->having('order_count', '>', 1)
            ->count();
            
        $totalCustomers = User::count();
        $customerRetentionRate = $totalCustomers > 0 
            ? round(($repeatedCustomers / $totalCustomers) * 100, 2) 
            : 0;
            
        return Inertia::render('Admin/Reports/Customers', [
            'topCustomers' => $topCustomers,
            'newCustomers' => $newCustomers,
            'totalCustomers' => $totalCustomers,
            'repeatedCustomers' => $repeatedCustomers,
            'customerRetentionRate' => $customerRetentionRate
        ]);
    }
}
