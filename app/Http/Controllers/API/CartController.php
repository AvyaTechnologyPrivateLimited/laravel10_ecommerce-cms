<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{Cart, Product};

use Illuminate\Http\Request;
use App\Helpers\CartHelper;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function add_to_cart(Request $request)
    {
        $validated = CartHelper::addToCartValidation($request);

        if($validated['response']=='error') {
            return response()->json($validated, 422);
        }

        //product validated and ready to add into cart
        return [
            'current'=>CartHelper::add($request, $validated['product']),
            'all'=>CartHelper::getContent()
        ];
    }

    public function carts()
    {
        //get cart detail
        return CartHelper::getContent();
    }
    
    public function remove(Request $request)
    {
        return CartHelper::remove($request);
    }
}
