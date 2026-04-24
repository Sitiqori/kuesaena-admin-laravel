<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('customer.pages.menu', compact('categories', 'products'));
    }
}
