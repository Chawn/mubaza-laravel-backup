<?php

use Illuminate\Database\Seeder;

class CommissionStatusTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('commission_statuses')->delete();

        App\CommissionStatus::create(['name' => 'approving', 'detail' => 'รอการตรวจสอบ']);
        App\CommissionStatus::create(['name' => 'approved', 'detail' => 'ตรวจสอบแล้ว']);
        App\CommissionStatus::create(['name' => 'paid', 'detail' => 'จ่ายแล้ว']);
        App\CommissionStatus::create(['name' => 'cancel', 'detail' => 'ยกเลิก']);
        App\CommissionStatus::create(['name' => 'fraud', 'detail' => 'ผิดกฏ']);
    }
}
