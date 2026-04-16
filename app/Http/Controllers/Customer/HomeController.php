<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ Produk
        $products = Product::with('category')
            ->where('stock', '>', 0) // ganti stok → stock
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        // ✅ Kategori
        $categories = Category::orderBy('name')->get();

        // ✅ Testimoni
        $testimonials = [
            [
                'name'   => 'Sari90',
                'rating' => 5,
                'review' => 'Kue ulang tahunnya tidak hanya cantik tapi juga enak banget! Keluarga sampai berebut.',
                'avatar' => null,
            ],
            [
                'name'   => 'Dewi_K',
                'rating' => 5,
                'review' => 'Orderan hampers selalu di sini. Kualitas top!',
                'avatar' => null,
            ],
            [
                'name'   => 'Budi123',
                'rating' => 5,
                'review' => 'Pesannya gampang, rasanya enak. Recommended!',
                'avatar' => null,
            ],
        ];

        return view('customer.pages.home', compact(
            'products',
            'categories',
            'testimonials'
        ));
    }
}
