<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display the reports dashboard.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // Get summary statistics
        $totalRevenue = Order::where('status', '!=', 'refunded')
            ->where('status', '!=', 'cancelled')
            ->sum('total');
        
        $totalOrders = Order::count();
        $totalCustomers = User::where('is_admin', false)->count();
        $totalProducts = Product::count();
        
        // Get recent orders for quick overview
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'customer_name' => $order->user->name,
                    'status' => $order->status,
                    'total' => $order->total,
                    'created_at' => $order->created_at,
                ];
            });
        
        // Sales statistics by month (last 6 months)
        $salesByMonth = $this->getSalesByMonth();
        
        return Inertia::render('Admin/Reports/Index', [
            'statistics' => [
                'totalRevenue' => $totalRevenue,
                'totalOrders' => $totalOrders,
                'totalCustomers' => $totalCustomers,
                'totalProducts' => $totalProducts,
            ],
            'recentOrders' => $recentOrders,
            'salesByMonth' => $salesByMonth,
        ]);
    }
    
    /**
     * Display detailed sales reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function sales(Request $request)
    {
        // Set default date range if not provided
        $startDate = $request->start_date ? date('Y-m-d', strtotime($request->start_date)) : date('Y-m-d', strtotime('-30 days'));
        $endDate = $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : date('Y-m-d');
        
        // Get sales data by day in the date range
        $salesByDay = Order::where('status', '!=', 'refunded')
            ->where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total) as total_sales')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Get sales data by product
        $salesByProduct = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', '!=', 'refunded')
            ->where('orders.status', '!=', 'cancelled')
            ->whereDate('orders.created_at', '>=', $startDate)
            ->whereDate('orders.created_at', '<=', $endDate)
            ->select(
                'products.id',
                'products.name',
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_sales')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sales')
            ->get();
        
        return Inertia::render('Admin/Reports/Sales', [
            'salesByDay' => $salesByDay,
            'salesByProduct' => $salesByProduct,
            'dateRange' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ],
        ]);
    }
    
    /**
     * Display customer reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function customers(Request $request)
    {
        // Get top customers by revenue
        $topCustomers = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.status', '!=', 'refunded')
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as order_count'),
                DB::raw('SUM(orders.total) as total_spent'),
                DB::raw('MAX(orders.created_at) as last_order_date')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();
        
        // New customers by month
        $newCustomersByMonth = DB::table('users')
            ->where('is_admin', false)
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Customer retention data (this is a placeholder - implement your retention logic)
        $customerRetention = [
            'overall_retention_rate' => 75, // Placeholder value
            'monthly_retention' => [
                ['month' => '2023-01', 'rate' => 78],
                ['month' => '2023-02', 'rate' => 76],
                ['month' => '2023-03', 'rate' => 74],
                ['month' => '2023-04', 'rate' => 75],
                ['month' => '2023-05', 'rate' => 77],
                ['month' => '2023-06', 'rate' => 75],
            ],
        ];
        
        return Inertia::render('Admin/Reports/Customers', [
            'topCustomers' => $topCustomers,
            'newCustomersByMonth' => $newCustomersByMonth,
            'customerRetention' => $customerRetention,
        ]);
    }
    
    /**
     * Get sales data by month for the last 6 months.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getSalesByMonth()
    {
        return DB::table('orders')
            ->where('status', '!=', 'refunded')
            ->where('status', '!=', 'cancelled')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total) as total_sales')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}