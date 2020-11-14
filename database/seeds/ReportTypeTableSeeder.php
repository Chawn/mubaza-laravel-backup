<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ReportTypeTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('report_types')->delete();
        App\ReportType::create(['name' => 'privacy', 'detail' => 'รายงานการละเมิดลิขสิทธิ์']);
        App\ReportType::create(['name' => 'abuse', 'detail' => 'รายงานการโพสเนื้อหาที่ไม่เหมาะสม']);
        App\ReportType::create(['name' => 'etc', 'detail' => 'รายงานเรื่องอื่นๆ']);
    }

}