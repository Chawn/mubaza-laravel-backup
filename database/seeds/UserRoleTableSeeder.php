<?php
use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class UserRoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('user_roles')->delete();

        App\UserRole::create(['name' => 'admin', 'detail' => 'ผู้ดูแลระบบ']);
        App\UserRole::create(['name' => 'super', 'detail' => 'ผู้ใช้งานระดับสูง']);
        App\UserRole::create(['name' => 'user', 'detail' => 'ผู้ใช้งานทั่วไป']);
    }

}