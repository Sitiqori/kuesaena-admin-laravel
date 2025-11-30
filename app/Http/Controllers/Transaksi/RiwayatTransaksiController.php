<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        // Get all completed transactions
        $transactions = Order::with(['customer', 'orderItems.product', 'user'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $totalTransaksi = $transactions->count();
        $totalPenjualan = $transactions->sum('total');

        // Calculate laba kotor (assuming 30% profit margin)
        $labaKotor = $transactions->sum(function($transaction) {
            return $transaction->orderItems->sum(function($item) {
                // Laba = (Harga Jual - HPP) * Qty
                // HPP diasumsikan 70% dari harga jual
                $hpp = $item->price * 0.7;
                $laba = ($item->price - $hpp) * $item->quantity;
                return $laba;
            });
        });

        return view('transaksi.index', compact(
            'transactions',
            'totalTransaksi',
            'totalPenjualan',
            'labaKotor'
        ));
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'orderItems.product', 'user'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'order' => $order
        ]);
    }
}
