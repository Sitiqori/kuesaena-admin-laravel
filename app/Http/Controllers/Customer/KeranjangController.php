<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // Tampilkan halaman keranjang
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $rekomendasi = Product::where('stock', '>', 0)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('customer.pages.keranjang', compact('cartItems', 'rekomendasi', 'total'));
    }

    // Tambah produk ke keranjang
    public function tambah(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'flavor'     => 'nullable|string|max:100',
            'size'       => 'nullable|string|max:50',
            'note'       => 'nullable|string|max:255',
        ]);

        // Cek apakah produk sudah ada di keranjang
        $existing = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('flavor', $request->flavor)
            ->where('size', $request->size)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
                'flavor'     => $request->flavor,
                'size'       => $request->size,
                'note'       => $request->note,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Update kuantitas item
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cart->update(['quantity' => $request->quantity]);

        return response()->json([
            'success'  => true,
            'subtotal' => number_format($cart->product->price * $cart->quantity, 0, ',', '.'),
        ]);
    }

    // Hapus satu item
    public function hapus($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    // Hapus semua item
    public function hapusSemua()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}