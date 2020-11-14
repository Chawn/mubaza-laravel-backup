<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AdminRoleTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('admin_roles')->delete();
        App\AdminRole::create(['name' => 'admin', 'detail' => 'ผู้ดูแลระบบ']);
        App\AdminRole::create(['name' => 'finance', 'detail' => 'ฝ่ายการเงิน']);
        App\AdminRole::create(['name' => 'production', 'detail' => 'ฝ่ายการผลิต']);
    }
}
