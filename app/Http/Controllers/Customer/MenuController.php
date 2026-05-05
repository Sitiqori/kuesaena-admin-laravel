<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::orderBy('name')->get()->unique('name')->values();

        $query = Product::with('category')
            ->where('stock', '>', 0);

        // 🔍 SEARCH
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // 📂 FILTER CATEGORY
        if ($request->has('categories') && is_array($request->categories)) {
            $selectedNames = Category::whereIn('id', $request->categories)->pluck('name');
            $allIds = Category::whereIn('name', $selectedNames)->pluck('id');
            $query->whereIn('category_id', $allIds);
        }
       
        // 💰 FILTER PRICE
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 🔃 SORTING
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

        $products = $query->paginate(12)->withQueryString();

        $wishlistIds = [];
        $cartQuantities = [];
        if (auth()->check()) {
            $user = auth()->user();
            $wishlistIds = $user->wishlists()->pluck('product_id')->toArray();
            $cartQuantities = \App\Models\Cart::where('user_id', $user->id)
                ->selectRaw('product_id, SUM(quantity) as total_qty')
                ->groupBy('product_id')
                ->pluck('total_qty', 'product_id')
                ->toArray();
        }

        return view('customer.pages.menu', compact('categories', 'products', 'search', 'wishlistIds', 'cartQuantities'));
    }
}
