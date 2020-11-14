<?php

use Illuminate\Database\Seeder;

class ProductColorTableSeeder extends Seeder
{

    public function run ()
    {
        DB::table('product_colors')->delete();
        App\ProductColor::create([
            'color'            => '#000000',
            'color_name'       => 'สีดำ',
            'image_front'      => '000002/',
            'image_front_thmb' => NULL,
            'image_back'       => '000002/',
            'image_back_thmb'  => NULL,
            'primary' => 1,
            'product_id'       => 2
        ]);
        App\ProductColor::create([
            'color'            => '#ffffff',
            'color_name'       => 'สีขาว',
            'image_front'      => '000002/',
            'image_front_thmb' => NULL,
            'image_back'       => '000002/',
            'image_back_thmb'  => NULL,
            'product_id'       => 2
        ]);
        App\ProductColor::create([
            'color'            => '#011993',
            'color_name'       => 'สีกรมท่า',
            'image_front'      => '000002/',
            'image_front_thmb' => NULL,
            'image_back'       => '000002/',
            'image_back_thmb'  => NULL,
            'product_id'       => 2
        ]);
        App\ProductColor::create([
            'color'            => '#a4a4a4',
            'color_name'       => 'สีเทา',
            'image_front'      => '000002/',
            'image_front_thmb' => NULL,
            'image_back'       => '000002/',
            'image_back_thmb'  => NULL,
            'product_id'       => 2
        ]);
        App\ProductColor::create([
            'color'            => '#000000',
            'color_name'       => 'สีดำ',
            'image_front'      => '000001/',
            'image_front_thmb' => NULL,
            'image_back'       => '000001/',
            'image_back_thmb'  => NULL,
            'product_id'       => 1
        ]);
        App\ProductColor::create([
            'color'            => '#ffffff',
            'color_name'       => 'สีขาว',
            'image_front'      => '000001/',
            'image_front_thmb' => NULL,
            'image_back'       => '000001/',
            'image_back_thmb'  => NULL,
            'product_id'       => 1
        ]);
        App\ProductColor::create([
            'color'            => '#000080',
            'color_name'       => 'สีกรมท่า',
            'image_front'      => '000001/',
            'image_front_thmb' => NULL,
            'image_back'       => '000001/',
            'image_back_thmb'  => NULL,
            'primary' => 1,
            'product_id'       => 1
        ]);
        App\ProductColor::create([
            'color'            => '#a4a4a4',
            'color_name'       => 'สีเทา (ผ้า TC)',
            'image_front'      => '000001/',
            'image_front_thmb' => NULL,
            'image_back'       => '000001/',
            'image_back_thmb'  => NULL,
            'product_id'       => 1
        ]);
    }

}