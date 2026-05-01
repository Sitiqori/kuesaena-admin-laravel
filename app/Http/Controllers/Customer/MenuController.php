<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
<<<<<<< HEAD
    public function index(Request $request)
    {
        $categories = Category::all();
        
        $query = Product::with('category')->where('stock', '>', 0);
        
        // Filter by Categories
        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }
        
        // Filter by Price Range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sorting
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'terbaru':
                    $query->latest();
                    break;
                case 'terlaris':
                    $query->withCount('orderItems')->orderByDesc('order_items_count');
                    break;
                case 'terendah':
                    $query->orderBy('price', 'asc');
                    break;
                case 'tertinggi':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->orderBy('name');
                    break;
            }
        } else {
            $query->orderBy('name');
        }

        $products = $query->get();
=======
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();
>>>>>>> d07f41bcb216716dc31f54d38658c83380117c94

        return view('customer.pages.menu', compact('categories', 'products'));
    }
}
