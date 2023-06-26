<?php
namespace App\Helpers;
use Illuminate\Http\Request;
use App\Models\{
    Product,
    Cart
};

class CartHelper
{
    public static function addToCartValidation(Request $request)
    {
        $response = [
            'response' => null,
            'message' => null,
            'validated' => null
        ];

        if($request->quantity < 1)
        {
            //select qty invalid
            $response['response'] = 'error';
            $response['message'] = 'Please select valid quantity';
            return $response;
        }

        $product = Product::find($request->productId);

        if(!$product)
        {
            //product not found
            $response['response'] = 'error';
            $response['message'] = 'Product not found';
            return $response;
        }

        if($product->status==0)
        {
            //product disabled
            $response['response'] = 'error';
            $response['message'] = 'Product not available for checkout';
            return $response;
        }

        if($product->quantity < 1)
        {
            //product qty not available
            $response['response'] = 'error';
            $response['message'] = 'Product is out of stock';
            return $response;
        }

        if($request->quantity > $product->quantity)
        {
            //request qty is greater than prduct qty
            $response['response'] = 'error';
            $response['message'] = 'Requested quantity is greatet than product quantity';
            return $response;
        }

        $response['response'] = 'success';
        $response['product'] = $product;
        $response['message'] = 'Product added to cart';

        return $response;
    }
    public static function add(Request $request, $product) {

        $cart = Cart::updateOrCreate([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'size' => $request->size,
            'color' => $request->color
        ],[
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'image' => $product->originalImage,
        ]);

        return $cart;
    }
    public static function getContent() {
        $carts = Cart::GetData()->get();
        $total_item = $carts->count();
        $total_price = 0;
        if($total_item)
        {
            foreach($carts as $cart):
                $total_price += ($cart->price*$cart->quantity);
            endforeach;
        }
        return [
            'content' => $carts,
            'total_item' => $total_item,
            'total_price' => $total_price
        ];
    }
    public static function remove(Request $request) {
        
        Cart::Me()->find($request->id)->delete();
        
        return [
            'response' => 'success',
            'message' => 'Product deleted from cart',
        ];

    }
}