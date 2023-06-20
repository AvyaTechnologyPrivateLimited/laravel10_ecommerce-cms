<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ["XS", "S", "M", "L", "XL", "2XL", "3XL"];
        
        foreach($data as $value):
            Size::updateOrCreate([
                'name' => $value
            ]);
        endforeach;
    }
}
