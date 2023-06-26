<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{
    User, OrderAddress, Order, OrderProduct, Country
};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Auth;
use App\Helpers\CartHelper;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function update_contact_information(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|max:15',
            'email' => 'required|string|email|max:50'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        OrderAddress::updateOrCreate([
            'user_id' => auth()->id(),
            'order_id'=>0
        ],[
            'name'=>auth()->user()->name,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'newsletter'=>$request->newsletter?1:0
        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Contact information updated successfully.'
        ]);
    }
    public function shipping_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:25',
            'address_1' => 'required',
            'city' => 'required',
            'country' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        OrderAddress::updateOrCreate([
            'user_id' => auth()->id(),
            'order_id'=>0
        ],[
            'name'=>$request->name,
            'address_1'=>$request->address_1,
            'address_2'=>$request->address_2,
            'city'=>$request->city,
            'country_id'=>$request->country_id,
            'state'=>$request->state,
            'postal_code'=>$request->postal_code,
            'address_type'=>$request->address_type
        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Shipping address updated successfully.'
        ]);
    }
    public function checkout()
    {
        $carts = CartHelper::getContent();

        $latestOrder = Order::orderBy('id','desc')->first();
        $order_num = 'ORD'.str_pad($latestOrder->id + 1, 6, "0", STR_PAD_LEFT);
        
        Order::create([
            'user_id'=>auth()->id()??1,
            'order_num'=>$order_num,
            'total_price'=>$carts['total_price']
        ]);


        foreach($carts['content'] as $cart):
            OrderProduct::create([
                'product_id'=>$cart->product_id,
                'name'=>$cart['name'],
                'price'=>$cart['price'],
                'image'=>$cart['image'],
                'quantity'=>$cart['quantity'],
                'color'=>$cart['color'],
                'size'=>$cart['size'],
                'status'=>$cart['status']
            ]);
        endforeach;

        return response()->json([
            'success'=>true,
            'message'=>'Order placed successfully',
            'order_num'=>$order_num
        ]);
    }
    public function countries()
    {
        return Country::getData()->get();
    }
}
