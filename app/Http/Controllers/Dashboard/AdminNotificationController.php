<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function list()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->take(10)
            ->get();

        $notifications = $orders->map(function ($order) {
            $colorMap = [
                'pending'    => '#e67e22',
                'processing' => '#2980b9',
                'ready'      => '#8e44ad',
                'completed'  => '#27ae60',
                'cancelled'  => '#e74c3c',
            ];
            $iconMap = [
                'pending'    => 'fa-clock',
                'processing' => 'fa-box',
                'ready'      => 'fa-check',
                'completed'  => 'fa-star',
                'cancelled'  => 'fa-times',
            ];
            $labelMap = [
                'pending'    => 'Pesanan Baru',
                'processing' => 'Sedang Dikemas',
                'ready'      => 'Siap Diambil',
                'completed'  => 'Selesai',
                'cancelled'  => 'Dibatalkan',
            ];

            // Ambil nama produk
            $productNames = $order->orderItems->map(fn($item) => $item->product->name ?? 'Produk dihapus')->implode(', ');

            return [
                'id'      => $order->id,
                'title'   => ($labelMap[$order->status] ?? 'Pesanan') . ' - ' . $order->order_number,
                'body'    => $productNames . ' · ' . ($order->user?->name ?? 'Customer'),
                'details' => 'Rp ' . number_format($order->total, 0, ',', '.'),
                'color'   => $colorMap[$order->status] ?? '#888',
                'icon'    => $iconMap[$order->status] ?? 'fa-shopping-bag',
                'is_read' => $order->status !== 'pending',
                'time'    => $order->created_at->diffForHumans(),
            ];
        });

        $unread = Order::where('status', 'pending')->count();

        return response()->json([
            'notifications' => $notifications,
            'unread'        => $unread,
        ]);
    }

    // Check new orders for polling
    public function checkOrders()
    {
        $pendingCount = Order::where('status', 'pending')->count();
        $unread       = $pendingCount;

        return response()->json([
            'new_orders' => $pendingCount,
            'unread'     => $unread,
        ]);
    }

    // Mark all as read (just returns OK — admin notif is order-based)
    public function markAllRead()
    {
        return response()->json(['success' => true]);
    }
}
