<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = ['title', 'image', 'status'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeGetData($q)
    {
        return $q->select('title as name', 'slug', 'id')->where('status',1);
    }

    public function scopeFrontMainCategory($q)
    {
        return $q->select('title as name', 'slug as href', 'id')->where('status',1);
    }

    public function getImageAttribute($value)
    {
        return $value ? asset('uploads/'.$value) : asset('dummy.jpg');
    }
}
