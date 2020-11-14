<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class CampaignShippingStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('campaign_shipping_statuses')->delete();

        App\CampaignShippingStatus::create(['name' => 'waiting', 'detail' => 'รอดำเนินการผลิต']);
        App\CampaignShippingStatus::create(['name' => 'shipped', 'detail' => 'จัดส่งเรียบร้อยแล้ว']);
    }

}