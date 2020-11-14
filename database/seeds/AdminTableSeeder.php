<?php
use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AdminTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('admins')->delete();

        App\Admin::create(['email' => 'admin@mubaza.com', 'password' => bcrypt('123456')]);
        App\Admin::create(['email' => 'user@mubaza.com', 'password' => bcrypt('123456')]);
    }

}