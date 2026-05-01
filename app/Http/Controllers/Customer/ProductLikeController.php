<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductLikeController extends Controller
{
    public function index()
    {
        $likedProducts = Auth::user()->productLikes()->with('product')->latest()->get();
        return view('customer.pages.profil.like', compact('likedProducts'));
    }
    
    public function toggle(Request $request, Product $product)
    {
        $user = Auth::user();
        $like = ProductLike::where('user_id', $user->id)
                          ->where('product_id', $product->id)
                          ->first();
        
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            ProductLike::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
            $liked = true;
        }
        
        $totalLikes = $product->likes()->count();
        
        if ($request->ajax()) {
            return response()->json([
                'liked' => $liked,
                'total_likes' => $totalLikes
            ]);
        }
        
        return back();
    }
}
