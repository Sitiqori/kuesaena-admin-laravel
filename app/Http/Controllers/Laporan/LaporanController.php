<?php

namespace App\Http\Controllers\Laporan;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        // Stats
        $pesananBaru = Order::where('status', 'pending')->count();
        $pesananDiproses = Order::where('status', 'processing')->count();
        $penjualanBulan = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->count();
        $adminAktif = User::where('is_active', true)->count();

        // Expenses
        $expenses = Expense::with('user')
            ->whereMonth('date', now()->month)
            ->orderBy('date', 'desc')
            ->get();

        $totalPengeluaran = $expenses->sum('amount');

        // Top Products (Best Sellers)
        $topProducts = Product::select('products.*',
                DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereMonth('orders.created_at', now()->month)
            ->with('category')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Chart Data
        $chartData = $this->generateChartData();

        return view('laporan.index', compact(
            'pesananBaru',
            'pesananDiproses',
            'penjualanBulan',
            'adminAktif',
            'expenses',
            'totalPengeluaran',
            'topProducts',
            'chartData'
        ));
    }

    private function generateChartData()
    {
        $data = [];

        for ($month = 1; $month <= 12; $month++) {
            $daysInMonth = Carbon::create(now()->year, $month)->daysInMonth;
            $labels = [];
            $revenue = [];
            $expense = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create(now()->year, $month, $day);
                $labels[] = $day . ' ' . $date->format('M');

                // Revenue
                $dailyRevenue = Order::where('status', 'completed')
                    ->whereDate('created_at', $date)
                    ->sum('total');
                $revenue[] = $dailyRevenue;

                // Expense
                $dailyExpense = Expense::whereDate('date', $date)->sum('amount');
                $expense[] = $dailyExpense;
            }

            $data[$month] = [
                'labels' => $labels,
                'revenue' => $revenue,
                'expense' => $expense,
            ];
        }

        return $data;
    }

    public function exportPdf(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = now()->year;

        // Orders
        $orders = Order::with(['customer', 'orderItems.product', 'user'])
            ->where('status', 'completed')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')
            ->get();

        // Expenses
        $expenses = Expense::with('user')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();

        // Top Products
        $topProducts = Product::select('products.*',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.subtotal) as total_revenue'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereMonth('orders.created_at', $month)
            ->whereYear('orders.created_at', $year)
            ->with('category')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Calculations
        $totalPendapatan = $orders->sum('total');
        $totalPengeluaran = $expenses->sum('amount');
        $labaKotor = $totalPendapatan - $totalPengeluaran;
        $totalTransaksi = $orders->count();

        $monthName = Carbon::create($year, $month)->format('F Y');

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'orders',
            'expenses',
            'topProducts',
            'totalPendapatan',
            'totalPengeluaran',
            'labaKotor',
            'totalTransaksi',
            'monthName',
            'month',
            'year'
        ));

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('laporan-lengkap-' . $month . '-' . $year . '.pdf');
    }
}
