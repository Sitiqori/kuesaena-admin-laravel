<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats Cards
        $pesananBaru = Order::where('status', 'pending')->count();
        $pesananDiproses = Order::where('status', 'processing')->count();

        // Total pendapatan (completed orders this month)
        $totalPendapatan = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Total pengeluaran (dummy data - bisa diganti dengan model Expense)
        $totalPengeluaran = 980000; // Placeholder

        // Recent Orders (Pesanan Baru - pending)
        $recentOrders = Order::with(['customer', 'orderItems.product'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Chart Data - Generate for all months
        $chartData = $this->generateChartData();

        return view('dashboard.index', compact(
            'pesananBaru',
            'pesananDiproses',
            'totalPendapatan',
            'totalPengeluaran',
            'recentOrders',
            'chartData'
        ));
    }

    private function generateChartData()
    {
        $data = [];

        // Generate data for each month
        for ($month = 1; $month <= 12; $month++) {
            $daysInMonth = Carbon::create(now()->year, $month)->daysInMonth;
            $labels = [];
            $revenue = [];
            $expense = [];

            // Generate daily data
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create(now()->year, $month, $day);
                $labels[] = $day . ' ' . $date->format('M');

                // Get actual revenue for this day
                $dailyRevenue = Order::where('status', 'completed')
                    ->whereDate('created_at', $date)
                    ->sum('total');

                $revenue[] = $dailyRevenue;

                // Generate dummy expense data (30-50% of revenue)
                $expense[] = $dailyRevenue > 0 ? $dailyRevenue * rand(30, 50) / 100 : 0;
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

        // Get orders for selected month
        $orders = Order::with(['customer', 'orderItems.product', 'user'])
            ->where('status', 'completed')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalPendapatan = $orders->sum('total');
        $totalTransaksi = $orders->count();

        // Estimate expenses (you can replace with actual expense model)
        $totalPengeluaran = $totalPendapatan * 0.4; // 40% of revenue
        $labaKotor = $totalPendapatan - $totalPengeluaran;

        $monthName = Carbon::create($year, $month)->format('F Y');

        $pdf = Pdf::loadView('dashboard.pdf', compact(
            'orders',
            'totalPendapatan',
            'totalTransaksi',
            'totalPengeluaran',
            'labaKotor',
            'monthName',
            'month',
            'year'
        ));

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('laporan-dashboard-' . $month . '-' . $year . '.pdf');
    }
}
