<?php

namespace App\Http\Controllers\Pesanan;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        // Pesanan dengan status pending
        $newOrders = Order::with(['customer', 'orderItems.product', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Pesanan dengan status processing
        $processingOrders = Order::with(['customer', 'orderItems.product', 'user'])
            ->where('status', 'processing')
            ->orderBy('created_at', 'desc')
            ->get();

        // Count pesanan selesai hari ini
        $completedToday = Order::where('status', 'completed')
            ->whereDate('updated_at', today())
            ->count();

        return view('pesanan.index', compact('newOrders', 'processingOrders', 'completedToday'));
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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        try {
            $order = Order::findOrFail($id);
            $oldStatus = $order->status;
            $order->status = $request->status;
            $order->save();

            // Log status change
            $user = Auth::user();
            Log::info("Order {$order->order_number} status changed from {$oldStatus} to {$request->status} by {$user->name}");


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

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            // Return stock to products
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            $order->delete();

            return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('pesanan.index')->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }
}
