<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, User, Cart};
use App\Helpers\CartHelper;

class TestController extends Controller
{
    public function test()
    {
        return 'md asif';
        return $cart = CartHelper::getContent();
        dd($cart);
        return Product::first()->originalImage;
        return Cart::getContent();
    }
}
