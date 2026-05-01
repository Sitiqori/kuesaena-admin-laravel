<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Tampilkan detail produk + produk populer lainnya.
     */
    public function show($id)
    {
        // Ambil produk utama atau 404
        $product = Product::with('category')->findOrFail($id);

        // Ambil 6 produk lain sebagai "Popular Products" (exclude produk ini)
        $popularProducts = Product::where('id', '!=', $id)
            ->where('stock', '>', 0)
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return view('customer.pages.show', compact('product', 'popularProducts'));
    }

    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        $testimonials = [];

        return view('customer.pages.home', compact('categories', 'products', 'testimonials'));
    }
}
