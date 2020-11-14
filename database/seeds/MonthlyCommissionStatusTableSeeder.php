<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class MonthlyCommissionStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('monthly_commission_statuses')->delete();

        App\MonthlyCommissionStatus::create(['name' => 'approving', 'detail' => 'รอการตรวจสอบ']);
        App\MonthlyCommissionStatus::create(['name' => 'approved', 'detail' => 'ตรววจสอบแล้']);
        App\MonthlyCommissionStatus::create(['name' => 'pending', 'detail' => 'รอการจ่ายเงิน']);
        App\MonthlyCommissionStatus::create(['name' => 'paid', 'detail' => 'จ่ายเงินแล้ว']);
    }
}