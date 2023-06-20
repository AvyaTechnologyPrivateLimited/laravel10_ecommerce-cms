<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{
    Category, Size, Color
};

use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filters()
    {
        $categories = Category::GetData()->get();
        $colors = Color::GetData()->get();
        $sizes = Size::GetData()->get();

        return [
            'filters' => [
                'categories'=>$categories,
                'sizes'=>$sizes,
                'colors'=>$colors
            ],
        ];
    }
}
