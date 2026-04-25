<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Auth::user()->wishlists()->with('product')->latest()->get();
        return view('customer.pages.profil.wishlist', compact('wishlists'));
    }
    
    public function toggle(Request $request, Product $product)
    {
        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)
                           ->where('product_id', $product->id)
                           ->first();
        
        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
            $status = 'added';
        }
        
        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'count' => $user->wishlists()->count()
            ]);
        }
        
        return back();
    }
    
    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }
        
        $wishlist->delete();
        return back()->with('success', 'Produk dihapus dari wishlist');
    }
}
