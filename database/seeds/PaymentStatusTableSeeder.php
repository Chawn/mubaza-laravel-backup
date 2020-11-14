<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class PaymentStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('payment_statuses')->delete();

        App\PaymentStatus::create(['name' => 'waiting', 'detail' => 'ยังไม่ได้ชำระเงิน']);
        App\PaymentStatus::create(['name' => 'approve', 'detail' => 'แจ้งชำระเงินแล้ว รอการตรวจสอบ']);
        App\PaymentStatus::create(['name' => 'paid', 'detail' => 'ชำระเงินเรียบร้อยแล้ว']);
        App\PaymentStatus::create(['name' => 'cancel', 'detail' => 'ยกเลิการสั่งซื้อ']);
    }

}