<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class OrderProduceStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('order_produce_statuses')->delete();

        App\OrderProduceStatus::create(['name' => 'approve', 'detail' => 'รอตรวจสอบการผลิต']);
        App\OrderProduceStatus::create(['name' => 'waiting', 'detail' => 'รอดำเนินการผลิต']);
        App\OrderProduceStatus::create(['name' => 'producing', 'detail' => 'กำลังดำเนินการผลิต']);
        App\OrderProduceStatus::create(['name' => 'shipping', 'detail' => 'รอการจัดส่ง']);
        App\OrderProduceStatus::create(['name' => 'shipped', 'detail' => 'จัดส่งเสร็จเรียบร้อย']);
        App\OrderProduceStatus::create(['name' => 'cancel', 'detail' => 'ยกเลิกการผลิต']);
    }

}