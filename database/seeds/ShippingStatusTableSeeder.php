<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ShippingStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('shipping_statuses')->delete();

        App\ShippingStatus::create(['name' => 'waiting', 'detail' => 'รอดำเนินการจัดส่ง']);
        App\ShippingStatus::create(['name' => 'shipping', 'detail' => 'กำลังจัดส่ง']);
        App\ShippingStatus::create(['name' => 'shipped', 'detail' => 'จัดส่งเรียบร้อยแล้ว']);
    }
}