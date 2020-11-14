<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ProductOutlineTableSeeder extends Seeder {

    public function run()
    {
        DB::table('product_outlines')->delete();

        App\ProductOutline::create([
            'outline_width' => 210,
            'outline_height' => 407,
            'outline_left' => 165,
            'outline_top' => 83,
            'id' => 1
        ]);
        App\ProductOutline::create([
            'outline_width' => 210,
            'outline_height' => 407,
            'outline_left' => 165,
            'outline_top' => 83,
            'id' => 2
        ]);
    }

}