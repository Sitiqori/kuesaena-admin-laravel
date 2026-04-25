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
                'pending'    => 'pending',
                'sedang-dikemas' => 'processing',
                'siap-diambil' => 'ready',
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
        $order = Order::with(['orderItems.product', 'review'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.pages.pesanan.detail', compact('order'));
    }

    public function storeReview(Request $request, $id)
{
    $request->validate([
        'name'   => 'required|string|max:100',
        'body'   => 'required|string|max:500',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $order = Order::where('user_id', Auth::id())
        ->where('status', 'completed')
        ->findOrFail($id);

    if ($order->review) {
        return back()->with('error', 'Ulasan sudah pernah diberikan.');
    }

    \App\Models\Review::create([
        'order_id' => $order->id,
        'user_id'  => Auth::id(),
        'name'     => $request->name,
        'body'     => $request->body,
        'rating'   => $request->rating,
    ]);

    return back()->with('success', 'Ulasan berhasil disimpan!');
    }
}
