<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class FrontController extends Controller
{
    public function get_countries() {

        $data = [];
        $countries = Country::get();
        foreach($countries as $key => $country) {
            $data[$key]['value'] = $country->id;
            $data[$key]['label'] = $country->name;
        }

        return response()->json(['error' => false, 'data' => $data]);

    }
}
