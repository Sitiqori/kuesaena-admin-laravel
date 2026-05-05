<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function checkout(Request $request)
    {
        $selectedIds = $request->input('items') ? explode(',', $request->input('items')) : [];

        $query = Cart::with('product')->where('user_id', Auth::id());

        if (!empty($selectedIds)) {
            $query->whereIn('id', $selectedIds);
        }

        $cartItems = $query->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang kamu masih kosong!');
        }

        // Simpan ID yang dipilih ke session
        session(['selected_cart_ids' => $cartItems->pluck('id')->toArray()]);

        $addresses = UserAddress::where('user_id', Auth::id())->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('customer.pages.checkout', compact('cartItems', 'addresses', 'total'));
    }

    public function pilihPembayaran(Request $request)
    {
        $deliveryMethod = is_array($request->delivery_method)
            ? $request->delivery_method[0]
            : $request->delivery_method;

        $cakeFlavor = is_array($request->cake_flavor)
            ? implode(', ', array_filter($request->cake_flavor))
            : $request->cake_flavor;

        $size = is_array($request->size)
            ? implode(', ', array_filter($request->size))
            : $request->size;

        $notes = is_array($request->notes)
            ? implode(', ', array_filter($request->notes))
            : $request->notes;

        $deliveryMethods = $request->input('delivery_method', []);
        $needsAddress = in_array('antar', (array) $deliveryMethods);

        if ($needsAddress && empty($request->address_id)) {
            return redirect()->route('checkout')
                ->withInput()
                ->with('error', 'Kamu memilih pengiriman "Antar" tapi belum ada alamat. Silakan tambah alamat terlebih dahulu.');
        }

        $request->validate([
            'address_id' => 'nullable|exists:user_addresses,id',
        ]);

        session([
            'checkout_data' => [
                'delivery_method' => $deliveryMethod ?? 'pickup',
                'address_id'      => $request->address_id,
                'size'            => $size,
                'cake_flavor'     => $cakeFlavor,
                'notes'           => $notes,
            ]
        ]);

        $selectedIds = session('selected_cart_ids', []);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->when(!empty($selectedIds), fn($q) => $q->whereIn('id', $selectedIds))
            ->get();

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $address = $request->address_id ? UserAddress::find($request->address_id) : null;

        return view('customer.pages.pembayaran', compact('cartItems', 'total', 'address'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,shopee_pay,dana,gopay,ovo,cod,kartu_kredit,transfer_bank',
        ]);

        $selectedIds = session('selected_cart_ids', []);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->when(!empty($selectedIds), fn($q) => $q->whereIn('id', $selectedIds))
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang kamu kosong!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $checkoutData = session('checkout_data', []);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'         => Auth::id(),
                'order_number'    => Order::generateOrderNumber(),
                'subtotal'        => $subtotal,
                'tax'             => 0,
                'discount'        => 0,
                'total'           => $subtotal,
                'payment_method'  => $request->payment_method,
                'delivery_method' => $checkoutData['delivery_method'] ?? 'pickup',
                'size'            => $checkoutData['size'] ?? null,
                'cake_flavor'     => $checkoutData['cake_flavor'] ?? null,
                'notes'           => $checkoutData['notes'] ?? null,
                'status'          => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                    'subtotal'   => $item->product->price * $item->quantity,
                ]);
            }

            // Hapus hanya item yang dipilih
            Cart::where('user_id', Auth::id())
                ->when(!empty($selectedIds), fn($q) => $q->whereIn('id', $selectedIds))
                ->delete();

            session()->forget('checkout_data');
            session()->forget('selected_cart_ids');

            DB::commit();

            // ── Kirim notifikasi pesanan masuk ──────────────────────────────
            try {
                NotificationService::pesananMasuk(Auth::id(), $order->order_number);
            } catch (\Exception $e) {
                // notifikasi gagal tidak batalkan order
            }

            return redirect()->route('pembayaran.berhasil', $order->order_number);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function berhasil($orderNumber)
    {
        $order = Order::with('orderItems.product')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('customer.pages.berhasil', compact('order'));
    }
}