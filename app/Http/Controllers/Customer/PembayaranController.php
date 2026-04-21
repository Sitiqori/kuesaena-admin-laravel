<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    // Halaman checkout — tampilkan isi keranjang + form detail pesanan
    public function checkout()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang kamu masih kosong!');
        }

        $addresses = UserAddress::where('user_id', Auth::id())->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('customer.pages.checkout', compact('cartItems', 'addresses', 'total'));
    }

    // Proses dari checkout → ke halaman pilih pembayaran
    public function pilihPembayaran(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:pickup,delivery',
            'address_id'      => 'required_if:delivery_method,delivery|nullable|exists:user_addresses,id',
            'size'            => 'nullable|string|max:50',
            'cake_flavor'     => 'nullable|string|max:100',
            'notes'           => 'nullable|string|max:255',
        ]);

        // Simpan data checkout ke session
        session([
            'checkout_data' => [
                'delivery_method' => $request->delivery_method,
                'address_id'      => $request->address_id,
                'size'            => $request->size,
                'cake_flavor'     => $request->cake_flavor,
                'notes'           => $request->notes,
            ]
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $address = $request->address_id
            ? UserAddress::find($request->address_id)
            : null;

        return view('customer.pages.pembayaran', compact('cartItems', 'total', 'address'));
    }

    // Proses pembayaran → buat order → redirect ke halaman berhasil
    public function proses(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,shopee_pay,dana,gopay,ovo,cod,kartu_kredit,transfer_bank',
        ]);

        $checkoutData = session('checkout_data');

        if (!$checkoutData) {
            return redirect()->route('checkout')
                ->with('error', 'Sesi checkout sudah habis, silakan ulangi.');
        }

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang kamu kosong!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        DB::beginTransaction();
        try {
            // Buat order
            $order = Order::create([
                'user_id'         => Auth::id(),
                'order_number'    => Order::generateOrderNumber(),
                'subtotal'        => $subtotal,
                'tax'             => 0,
                'discount'        => 0,
                'total'           => $subtotal,
                'payment_method'  => $request->payment_method,
                'delivery_method' => $checkoutData['delivery_method'],
                'size'            => $checkoutData['size'],
                'cake_flavor'     => $checkoutData['cake_flavor'],
                'notes'           => $checkoutData['notes'],
                'status'          => 'pending',
            ]);

            // Buat order items dari keranjang
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                    'subtotal'   => $item->product->price * $item->quantity,
                ]);
            }

            // Kosongkan keranjang
            Cart::where('user_id', Auth::id())->delete();

            // Hapus session checkout
            session()->forget('checkout_data');

            DB::commit();

            return redirect()->route('pembayaran.berhasil', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    // Halaman pemesanan berhasil
    public function berhasil($orderNumber)
    {
        $order = Order::with('orderItems.product')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('customer.pages.berhasil', compact('order'));
    }
}