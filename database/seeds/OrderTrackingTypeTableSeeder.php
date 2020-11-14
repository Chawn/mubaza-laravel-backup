<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class OrderTrackingTypeTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('order_tracking_types')->delete();

        App\OrderTrackingType::create([
            'name' => 'open',
            'detail' => 'เริ่มต้นการสั่งซื้อ'
        ]);
        App\OrderTrackingType::create([
            'name' => 'cancel_by_user',
            'detail' => 'ยกเลิกการสั่งซื้อโดยผู้ใช้งาน'
        ]);
        App\OrderTrackingType::create([
            'name' => 'cancel_by_system',
            'detail' => 'ยกเลิกการสั่งซื้อโดยผู้ระบบ'
        ]);
        App\OrderTrackingType::create([
            'name' => 'updated-payment',
            'detail' => 'แจ้งชำระเงิน'
        ]);
        App\OrderTrackingType::create([
            'name' => 'paid',
            'detail' => 'ชำระเงินแล้ว'
        ]);
        App\OrderTrackingType::create([
            'name' => 'producing',
            'detail' => 'กำลังดำเนินการผลิต'
        ]);
        App\OrderTrackingType::create([
            'name' => 'produced',
            'detail' => 'ดำเนินการผลิตเสร็จแล้วเตรียมจัดส่ง'
        ]);
        App\OrderTrackingType::create([
            'name' => 'shipped',
            'detail' => 'จัดส่งแล้ว'
        ]);
        App\OrderTrackingType::create([
            'name' => 'received',
            'detail' => 'ได้รับของแล้ว'
        ]);
    }
}
