<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->latest();

        if ($status !== 'all') {
            $statusMap = [
                'belum-bayar'    => 'pending',
                'sedang-dikemas' => 'processing',
                'selesai'        => 'completed',
                'dibatalkan'     => 'cancelled',
            ];
            if (isset($statusMap[$status])) {
                $query->where('status', $statusMap[$status]);
            }
        }

        $orders = $query->get();

        return view('customer.pages.pesanan.index', compact('orders', 'status'));
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.pages.pesanan.detail', compact('order'));
    }
}
