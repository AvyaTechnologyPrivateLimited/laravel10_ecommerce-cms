<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function scopeGetData($q)
    {
        return $q->select('id', 'name')->where('status', 1);
    }
}
