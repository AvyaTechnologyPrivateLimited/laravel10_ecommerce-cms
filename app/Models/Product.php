<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

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

    public function scopeGetData($q)
    {
        return $q->select(
            'title as name',
            'slug',
            'id',
            'description',
            'price',
            'image',
            'badge',
            'features',
            'product_details',
            'quantity'
        )
        ->with(['api_colors', 'api_sizes', 'api_tags'])
        ->where('status',1);
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
