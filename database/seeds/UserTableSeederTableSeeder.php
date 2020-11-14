<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

//        App\User::create([
//            'full_name' => 'Test',
//            'email' => 'test@mubaza.com',
//            'password' => bcrypt('123456'),
//        ]);
        factory('App\User', 2)->create();
    }
}
