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

    public function pilihPembayaran(Request $request)
    {
        // delivery_method, size, cake_flavor, notes dikirim sebagai array (per item)
        $request->validate([
            'delivery_method'   => 'required|array',
            'delivery_method.*' => 'in:pickup,antar',
            'address_id'        => 'nullable|exists:user_addresses,id',
            'size'              => 'nullable|array',
            'size.*'            => 'nullable|string|max:50',
            'cake_flavor'       => 'nullable|array',
            'cake_flavor.*'     => 'nullable|string|max:100',
            'notes'             => 'nullable|array',
            'notes.*'           => 'nullable|string|max:255',
        ]);

        // Ambil nilai pertama untuk sesi (order masih 1 item per checkout)
        $deliveryMethods = $request->input('delivery_method', []);
        $sizes           = $request->input('size', []);
        $flavors         = $request->input('cake_flavor', []);
        $notes           = $request->input('notes', []);

        session([
            'checkout_data' => [
                'delivery_method' => $deliveryMethods[0] ?? 'pickup',
                'address_id'      => $request->address_id,
                'size'            => $sizes[0] ?? null,
                'cake_flavor'     => $flavors[0] ?? null,
                'notes'           => $notes[0] ?? null,
                // simpan semua array juga untuk multi-item kalau dibutuhkan
                'delivery_methods' => $deliveryMethods,
                'sizes'            => $sizes,
                'flavors'          => $flavors,
                'all_notes'        => $notes,
            ]
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        // Hitung total: kalau item punya size yang dipilih, pakai harga size
        $total = 0;
        foreach ($cartItems as $idx => $item) {
            $prod      = $item->product;
            $size      = $sizes[$idx] ?? null;
            $unitPrice = $prod->price; // default harga jual biasa

            if ($prod->has_size && $size) {
                $priceKey  = 'price_' . strtolower($size);
                $unitPrice = $prod->$priceKey ?? $prod->price;
            }

            $total += $unitPrice * $item->quantity;
        }

        $address = $request->address_id ? UserAddress::find($request->address_id) : null;

        return view('customer.pages.pembayaran', compact('cartItems', 'total', 'address'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,shopee_pay,dana,gopay,ovo,cod,kartu_kredit,transfer_bank',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang kamu kosong!');
        }

        $checkoutData    = session('checkout_data', []);
        $deliveryMethods = $checkoutData['delivery_methods'] ?? [$checkoutData['delivery_method'] ?? 'pickup'];
        $sizes           = $checkoutData['sizes']     ?? [$checkoutData['size']       ?? null];
        $flavors         = $checkoutData['flavors']   ?? [$checkoutData['cake_flavor'] ?? null];
        $allNotes        = $checkoutData['all_notes'] ?? [$checkoutData['notes']       ?? null];

        // Hitung subtotal dengan harga per ukuran
        $subtotal = 0;
        foreach ($cartItems as $idx => $item) {
            $prod      = $item->product;
            $size      = $sizes[$idx] ?? null;
            $unitPrice = $prod->price;

            if ($prod->has_size && $size) {
                $priceKey  = 'price_' . strtolower($size);
                $unitPrice = $prod->$priceKey ?? $prod->price;
            }

            $subtotal += $unitPrice * $item->quantity;
        }

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
                'delivery_method' => $deliveryMethods[0] ?? 'pickup',
                'size'            => $sizes[0] ?? null,
                'cake_flavor'     => $flavors[0] ?? null,
                'notes'           => $allNotes[0] ?? null,
                'status'          => 'processing',
            ]);

            foreach ($cartItems as $idx => $item) {
                $prod      = $item->product;
                $size      = $sizes[$idx] ?? null;
                $unitPrice = $prod->price;

                if ($prod->has_size && $size) {
                    $priceKey  = 'price_' . strtolower($size);
                    $unitPrice = $prod->$priceKey ?? $prod->price;
                }

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $unitPrice,
                    'subtotal'   => $unitPrice * $item->quantity,
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();
            session()->forget('checkout_data');
            DB::commit();

            return redirect()->route('pembayaran.berhasil', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
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