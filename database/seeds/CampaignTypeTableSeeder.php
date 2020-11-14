<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class CampaignTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('campaign_types')->delete();

        App\CampaignType::create([
            'name' => 'sell',
            'detail' => 'การสร้างเพื่อจำหน่าย'
        ]);
        App\CampaignType::create([
            'name' => 'buy',
            'detail' => 'การสร้างเพื่อซื้อ'
        ]);
    }

}