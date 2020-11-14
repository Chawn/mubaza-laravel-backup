<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class CampaignStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('campaign_statuses')->delete();

        App\CampaignStatus::create(['name' => 'active', 'detail' => 'กำลังทำงาน']);
        App\CampaignStatus::create(['name' => 'close', 'detail' => 'ปิดการทำงาน']);
        App\CampaignStatus::create(['name' => 'ban', 'detail' => 'ถูกระงับ']);
        App\CampaignStatus::create(['name' => 'user_delete', 'detail' => 'ถูกลบโดยผู้ใช้']);
        App\CampaignStatus::create(['name' => 'check', 'detail' => 'รอการตรวจสอบ']);
    }

}