<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use DB, Log, JWTAuth;
use App\Helpers\UserHelper;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasSlug;
    
    protected $fillable = ['category_id', 'slug', 'title', 'price', 'image', 'status', 'description', 'badge', 'features', 'product_details', 'quantity'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeGetData($q, $request)
    {
        $user = UserHelper::getUserFromJwtToken($request);
        return $q->select(
            'products.title as name',
            'products.slug',
            'products.id',
            'description',
            'price',
            'products.image',
            'badge',
            'features',
            'product_details',
            'quantity'
        )
        ->with([
            'api_colors', 
            'api_sizes', 
            'api_tags', 
            'wishlist' => function ($queryBuilder) use ($user) {
                $queryBuilder->where('user_id', $user->id??0);
            }])
       
        ->where('products.status',1);
    }

    public function wishlist()
    {
        return $this->hasOne(ProductWishlist::class);
    }

    public function scopeFilters($q, $request)
    {

        if($request->sort) {

            if($request->sort == 'Newest') {
                return $q->orderBy('products.id', 'DESC');
            }

            if($request->sort == 'Price-low-high') {
                return $q->orderBy('products.price', 'ASC');
            }

            if($request->sort == 'Price-high-low') {
                return $q->orderBy('products.price', 'DESC');
            }
            
        }

        if($request->category && !in_array('all-categories', $request->category)) {
            return $q->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                    ->whereIn('categories.slug', explode(',',$request->category));
        } 


        if($request->color) {
            return $q->leftJoin('color_product', 'products.id', '=', 'color_product.product_id')
                    ->leftJoin('colors', 'color_product.color_id', '=', 'colors.id')
                    ->whereIn('colors.slug', explode(',',strtolower($request->color)));
        }

        if($request->sizes) {
            $size_lower = trim(strtolower($request->sizes));
            return $q->leftJoin('product_size', 'products.id', '=', 'product_size.product_id')
                    ->leftJoin('sizes', 'product_size.size_id', '=', 'sizes.id')
                    ->whereIn('sizes.slug', explode(',',$size_lower));
        }

        if($request->price) {
            $price = explode(',', $request->price);
            return $q->whereBetween('products.price', $price);
        }


        

    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }
    public function api_colors()
    {
        return $this->belongsToMany(Color::class)->select('name', 'code', 'id');
    }

    public function colorMultiSelect()
    {
        return $this->belongsToMany(Color::class)->select('id as value', 'name as label', 'id as key', 'code');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }
    public function api_sizes()
    {
        return $this->belongsToMany(Size::class)->select('name', 'id');
    }

    public function sizeMultiSelect()
    {
        return $this->belongsToMany(Size::class)->select('id as value', 'name as label', 'id as key');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function api_tags()
    {
        return $this->belongsToMany(Tag::class)->select('name', 'id');
    }

    public function tagMultiSelect()
    {
        return $this->belongsToMany(Tag::class)->select('id as value', 'name as label', 'id as key');
    }

    public function getImageAttribute($value)
    {
        return $value ? asset('uploads/'.$value) : asset('dummy.jpg');
    }
    public function getOriginalImageAttribute()
    {
        return $this->attributes['image'];
    }
}
