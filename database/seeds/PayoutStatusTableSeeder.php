<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class PayoutStatusTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('payout_statuses')->delete();

        App\PayoutStatus::create(['name' => 'approved', 'detail' => 'ตรวจสอบแล้วรอการจ่ายเงิน']);
        App\PayoutStatus::create(['name' => 'paid', 'detail' => 'จ่ายเงินเรียบร้อยแล้ว']);
    }
}
