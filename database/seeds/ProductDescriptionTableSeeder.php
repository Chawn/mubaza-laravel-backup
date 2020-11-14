<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ProductDescriptionTableSeeder extends Seeder
{
    public function run()
    {

        DB::table('product_descriptions')->delete();

        App\ProductDescription::create([
            'id' => 1,
            's_height' => 25,
            's_width' => 32,
            'm_height' => 27,
            'm_width' => 36,
            'l_height' => 29,
            'l_width' => 40,
            'xl_height' => 30,
            'xl_width' => 42,
            'xxl_height' => 31,
            'xxl_width' => 46,
            'product_id' => 1
        ]);
        App\ProductDescription::create([
            'id' => 2,
            's_height' => 25,
            's_width' => 32,
            'm_height' => 27,
            'm_width' => 36,
            'l_height' => 29,
            'l_width' => 40,
            'xl_height' => 30,
            'xl_width' => 42,
            'xxl_height' => 31,
            'xxl_width' => 46,
            'product_id' => 2
        ]);
    }
}
