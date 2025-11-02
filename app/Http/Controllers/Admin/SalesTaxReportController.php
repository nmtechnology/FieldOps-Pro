<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\TaxService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SalesTaxReportController extends Controller
{
    protected $taxService;

    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    /**
     * Display the sales tax report
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Get tax summary by state
        $taxByState = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('buyer_state')
            ->where('tax_amount', '>', 0)
            ->select(
                'buyer_state',
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(subtotal) as total_sales'),
                DB::raw('SUM(tax_amount) as total_tax'),
                DB::raw('AVG(tax_rate) as avg_tax_rate')
            )
            ->groupBy('buyer_state')
            ->orderBy('total_tax', 'desc')
            ->get()
            ->map(function ($item) {
                $stateNames = $this->taxService->getStateNames();
                $item->state_name = $stateNames[$item->buyer_state] ?? $item->buyer_state;
                $item->avg_tax_rate_formatted = number_format($item->avg_tax_rate * 100, 2) . '%';
                return $item;
            });

        // Get overall totals
        $totals = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('tax_amount', '>', 0)
            ->select(
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(subtotal) as total_sales'),
                DB::raw('SUM(tax_amount) as total_tax'),
                DB::raw('SUM(subtotal + tax_amount) as grand_total')
            )
            ->first();

        // Get monthly breakdown
        $monthlyTax = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('tax_amount', '>', 0)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(tax_amount) as total_tax')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Get recent taxable orders
        $recentOrders = Order::with(['product', 'user'])
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('tax_amount', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($order) {
                $stateNames = $this->taxService->getStateNames();
                $order->state_name = $stateNames[$order->buyer_state] ?? $order->buyer_state;
                $order->tax_rate_formatted = number_format($order->tax_rate * 100, 2) . '%';
                return $order;
            });

        return Inertia::render('Admin/Reports/SalesTax', [
            'taxByState' => $taxByState,
            'totals' => $totals,
            'monthlyTax' => $monthlyTax,
            'recentOrders' => $recentOrders,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    /**
     * Export sales tax report to CSV
     */
    public function export(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $taxByState = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('buyer_state')
            ->where('tax_amount', '>', 0)
            ->select(
                'buyer_state',
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(subtotal) as total_sales'),
                DB::raw('SUM(tax_amount) as total_tax'),
                DB::raw('AVG(tax_rate) as avg_tax_rate')
            )
            ->groupBy('buyer_state')
            ->orderBy('buyer_state', 'asc')
            ->get();

        $filename = "sales-tax-report-{$startDate}-to-{$endDate}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($taxByState) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, ['State', 'State Code', 'Order Count', 'Total Sales', 'Tax Collected', 'Avg Tax Rate']);
            
            $stateNames = $this->taxService->getStateNames();
            
            foreach ($taxByState as $item) {
                fputcsv($file, [
                    $stateNames[$item->buyer_state] ?? $item->buyer_state,
                    $item->buyer_state,
                    $item->order_count,
                    number_format($item->total_sales, 2),
                    number_format($item->total_tax, 2),
                    number_format($item->avg_tax_rate * 100, 2) . '%',
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
