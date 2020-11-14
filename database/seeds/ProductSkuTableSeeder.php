<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ProductSkuTableSeeder extends Seeder
{

    public function run ()
    {
        DB::table('product_skus')->delete();
        App\ProductSku::create([
            'size'             => 'XS',
            'qty'              => 0,
            'product_color_id' => 1,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'S',
            'qty'              => 0,
            'product_color_id' => 1,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M1',
            'qty'              => 0,
            'product_color_id' => 1,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M2',
            'qty'              => 0,
            'product_color_id' => 1,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'L',
            'qty'              => 0,
            'product_color_id' => 1,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XL',
            'qty'              => 0,
            'product_color_id' => 1,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => '2XL',
            'qty'              => 0,
            'product_color_id' => 1,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XS',
            'qty'              => 0,
            'product_color_id' => 2,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'S',
            'qty'              => 0,
            'product_color_id' => 2,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M1',
            'qty'              => 0,
            'product_color_id' => 2,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M2',
            'qty'              => 0,
            'product_color_id' => 2,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'L',
            'qty'              => 0,
            'product_color_id' => 2,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XL',
            'qty'              => 0,
            'product_color_id' => 2,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => '2XL',
            'qty'              => 0,
            'product_color_id' => 2,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XS',
            'qty'              => 0,
            'product_color_id' => 3,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'S',
            'qty'              => 0,
            'product_color_id' => 3,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M1',
            'qty'              => 0,
            'product_color_id' => 3,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M2',
            'qty'              => 0,
            'product_color_id' => 3,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'L',
            'qty'              => 0,
            'product_color_id' => 3,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XL',
            'qty'              => 0,
            'product_color_id' => 3,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => '2XL',
            'qty'              => 0,
            'product_color_id' => 3,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XS',
            'qty'              => 0,
            'product_color_id' => 4,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'S',
            'qty'              => 0,
            'product_color_id' => 4,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M1',
            'qty'              => 0,
            'product_color_id' => 4,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M2',
            'qty'              => 0,
            'product_color_id' => 4,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'L',
            'qty'              => 0,
            'product_color_id' => 4,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XL',
            'qty'              => 0,
            'product_color_id' => 4,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => '2XL',
            'qty'              => 0,
            'product_color_id' => 4,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XS',
            'qty'              => 0,
            'product_color_id' => 5,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'S',
            'qty'              => 0,
            'product_color_id' => 5,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M1',
            'qty'              => 0,
            'product_color_id' => 5,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M2',
            'qty'              => 0,
            'product_color_id' => 5,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'L',
            'qty'              => 0,
            'product_color_id' => 5,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XL',
            'qty'              => 0,
            'product_color_id' => 5,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => '2XL',
            'qty'              => 0,
            'product_color_id' => 5,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XS',
            'qty'              => 0,
            'product_color_id' => 6,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'S',
            'qty'              => 0,
            'product_color_id' => 6,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M1',
            'qty'              => 0,
            'product_color_id' => 6,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M2',
            'qty'              => 0,
            'product_color_id' => 6,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'L',
            'qty'              => 0,
            'product_color_id' => 6,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XL',
            'qty'              => 0,
            'product_color_id' => 6,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => '2XL',
            'qty'              => 0,
            'product_color_id' => 6,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XS',
            'qty'              => 0,
            'product_color_id' => 7,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'S',
            'qty'              => 0,
            'product_color_id' => 7,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M1',
            'qty'              => 0,
            'product_color_id' => 7,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M2',
            'qty'              => 0,
            'product_color_id' => 7,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'L',
            'qty'              => 0,
            'product_color_id' => 7,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XL',
            'qty'              => 0,
            'product_color_id' => 7,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => '2XL',
            'qty'              => 0,
            'product_color_id' => 7,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XS',
            'qty'              => 0,
            'product_color_id' => 8,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'S',
            'qty'              => 0,
            'product_color_id' => 8,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M1',
            'qty'              => 0,
            'product_color_id' => 8,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'M2',
            'qty'              => 0,
            'product_color_id' => 8,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'L',
            'qty'              => 0,
            'product_color_id' => 8,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => 'XL',
            'qty'              => 0,
            'product_color_id' => 8,
            'is_active'        => true
        ]);
        App\ProductSku::create([
            'size'             => '2XL',
            'qty'              => 0,
            'product_color_id' => 8,
            'is_active'        => true
        ]);
    }

}