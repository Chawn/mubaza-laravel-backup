<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class NotificationTypeTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('notification_types')->delete();

        \App\NotificationType::create([
           'name' => 'user', 'detail' => 'การแจ้งเตือนส่วนผู้ใช้'
        ]);

        \App\NotificationType::create([
           'name' => 'associate', 'detail' => 'การแจ้งเตือนส่วน Associate'
        ]);
    }
}
