<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        return $value ? asset('uploads/'.$value) : asset('dummy.jpg');
    }
    public function scopeGetData($q)
    {
        return $q->select(
            'carts.id',
            'carts.user_id',
            'carts.product_id',
            'carts.name',
            'carts.image',
            'carts.quantity',
            'products.quantity as in_stock_qty',
            'carts.price',
            'carts.color',
            'carts.size',
            'carts.detail',
            DB::raw('carts.price*carts.quantity as total_price')
            )
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->Me();
    }
    public function scopeMe($q)
    {
        return $q->where('user_id', auth()->id());
    }
}
