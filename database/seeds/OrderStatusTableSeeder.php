<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class OrderStatusTableSeeder extends Seeder
{

    public function run ()
    {
        DB::table('order_statuses')->delete();

        App\OrderStatus::create([
            'name'   => 'open',
            'detail' => 'เริ่มต้นการสั่งซื้อ'
        ]);
        App\OrderStatus::create([
            'name'   => 'cancel',
            'detail' => 'ยกเลิก'
        ]);
        App\OrderStatus::create([
            'name'   => 'waiting_to_produce',
            'detail' => 'รอดำเนินการผลิต'
        ]);
        App\OrderStatus::create([
            'name'   => 'producing',
            'detail' => 'กำลังดำเนินการผลิต'
        ]);
        App\OrderStatus::create([
            'name'   => 'shipping',
            'detail' => 'รอการจัดส่ง'
        ]);
        App\OrderStatus::create([
            'name'   => 'shipped',
            'detail' => 'จัดส่งเสร็จเรียบร้อย'
        ]);
    }

}