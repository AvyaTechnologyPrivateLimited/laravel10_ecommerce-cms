<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ["violet"=>"#a88bfa", "yellow"=>"#facc14", "orange"=>"#fb923c", "sky"=>"#38bdf8", "green"=>"#4ade80"];
        
        foreach($data as $name=>$code):
            Color::updateOrCreate([
                'name' => $name
            ],[
                'code' => $code
            ]);
        endforeach;
    }
}
