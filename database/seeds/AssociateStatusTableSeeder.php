<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AssociateStatusTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('associate_statuses')->delete();
        \App\AssociateStatus::create(['name' => 'active', 'detail' => 'ปกติ']);
        \App\AssociateStatus::create(['name' => 'disabled', 'detail' => 'ปิดการใช้งาน']);
        \App\AssociateStatus::create(['name' => 'banned', 'detail' => 'ระงับการใช้งาน']);
    }
}
