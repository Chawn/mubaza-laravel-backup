<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ProductTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('products')->delete();

        App\Product::create([
            'name' => 'Original',
            'price' => 390,
            'one_side_price' => 390,
            'max_price' => 490,
            'category_id' => 1
        ]);
        App\Product::create([
            'name' => 'Super Soft',
            'price' => 590,
            'one_side_price' => 590,
            'max_price' => 690,
            'category_id' => 1
        ]);
    }

}