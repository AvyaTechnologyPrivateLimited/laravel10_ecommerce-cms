<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;

use Illuminate\Http\Request;
use Log, JWTAuth;

class ProductController extends Controller
{
    public function products(Request $request)
    {
        return Product::GetData($request)
                        ->Filters($request)
                        ->paginate(config('constants.pagination'));
    }

    public function show(Product $product)
    {
        $product = Product::GetData()
                            ->find($product->id);
        return $product;
    }
}
