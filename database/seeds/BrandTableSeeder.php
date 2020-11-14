<?php
use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class BrandTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('brands')->delete();

        App\Brand::create(['name' => 'Mubaza', 'detail' => 'Mubaza']);
    }

}