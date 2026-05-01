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

        $categories = Category::all();

        $query = Product::with('category')
            ->where('stock', '>', 0);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function ($q2) use ($search) {
                      $q2->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $products = $query->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('customer.pages.menu', compact('categories', 'products', 'search'));
    }
}
