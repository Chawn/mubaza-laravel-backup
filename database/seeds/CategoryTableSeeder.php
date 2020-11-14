<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class CategoryTableSeeder extends Seeder {

    public function run()
    {
        DB::table('categories')->delete();

        App\Category::create(['name' => 'men', 'detail' => 'เสื้อยืดผู้ชาย']);
        App\Category::create(['name' => 'woman', 'detail' => 'เสื้อยืดผู้หญิง']);
        App\Category::create(['name' => 'hood', 'detail' => 'เสื้อฮูด']);
        App\Category::create(['name' => 'child', 'detail' => 'เสื้อยืดเด็ก']);
    }

}