<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AdminStatusTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('admin_statuses')->delete();

        App\AdminStatus::create(['name' => 'active', 'detail' => 'ปรกติ']);
        App\AdminStatus::create(['name' => 'inactive', 'detail' => 'ยังไม่เปิดใช้งาน']);
        App\AdminStatus::create(['name' => 'banned', 'detail' => 'ระงับการใช้งาน']);
    }
}
