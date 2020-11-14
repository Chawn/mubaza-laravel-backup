<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class UserStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('user_statuses')->delete();

        App\UserStatus::create(['name' => 'normal', 'detail' => 'ปรกติ']);
        App\UserStatus::create(['name' => 'inactive', 'detail' => 'ยังไม่เปิดใช้งาน']);
        App\UserStatus::create(['name' => 'banned', 'detail' => 'ระงับการใช้งาน']);
    }

}