<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ProductTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('product_types')->delete();

        App\ProductType::create(['name' => 'เสื้อผ่าผู้ชาย']);
    }

}