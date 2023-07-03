<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\ProductWishlist;
use Illuminate\Http\Request;

class ProductWishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function toggle_wishlist(Request $request)
    {
        $productid = $request->productid;
        $user_id = auth()->id();
        $wishlistItem = ProductWishlist::where('user_id', $user_id)
            ->where('product_id', $request->productid)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $msg = 'Product removed from wishlist';
            $wishlisted = false;
        } else {
            $wishlistItem = new ProductWishlist();
            $wishlistItem->user_id = $user_id;
            $wishlistItem->product_id = $productid;
            $wishlistItem->save();
            $msg = 'Product added to wishlist';
            $wishlisted = true;
        }

        return [
            'response' => 'success',
            'message' => $msg,
            'wishlisted' => $wishlisted,
        ];
    }
}
