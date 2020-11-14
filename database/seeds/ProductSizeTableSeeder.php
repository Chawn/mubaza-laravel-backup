<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ProductSizeTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('product_sizes')->delete();

        App\ProductSize::create(
            [
                'name' => 'M',
                'product_id' => 1
            ]
        );

        App\ProductSize::create(
            [
                'name' => 'L',
                'product_id' => 1
            ]
        );
    }

}