<?php

namespace App\Http\Controllers\Pesanan;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderItems.product', 'user'])
            ->latest()
            ->get();

        $newOrders        = $orders->where('status', 'pending');
        $processingOrders = $orders->where('status', 'processing');
        $completedToday = $orders->where('status', 'completed')
            ->filter(fn($o) => $o->updated_at->isToday())
            ->count(); // tambah ->count()

        return view('pesanan.index', compact('orders', 'newOrders', 'processingOrders', 'completedToday'));
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);
        return view('pesanan.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,ready,completed,cancelled'
        ]);

        try {
            $order = Order::findOrFail($id);
            $oldStatus = $order->status;
            $order->status = $request->status;
            $order->save();

            $user = Auth::user();
            Log::info("Order {$order->order_number} status changed from {$oldStatus} to {$request->status} by {$user->name}");

            // Kirim notifikasi ke customer berdasarkan status baru
            if ($order->user_id && $oldStatus !== $request->status) {
                match($request->status) {
                    'processing' => NotificationService::pesananDiproses($order->user_id, $order->order_number),
                    'ready'      => NotificationService::pesananSiap($order->user_id, $order->order_number, $order->delivery_method ?? 'pickup'),
                    'completed'  => NotificationService::pesananSelesai($order->user_id, $order->order_number),
                    'cancelled'  => NotificationService::pesananDibatalkan($order->user_id, $order->order_number),
                    default      => null,
                };
            }

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}